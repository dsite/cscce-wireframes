import ctEvents from 'ct-events'
import { registerDynamicChunk, markImagesAsLoaded } from 'blocksy-frontend'

function updateQueryStringParameter(uri, key, value) {
	var re = new RegExp('([?&])' + key + '=.*?(&|#|$)', 'i')
	if (uri.match(re)) {
		return uri.replace(re, '$1' + key + '=' + value + '$2')
	} else {
		var hash = ''
		if (uri.indexOf('#') !== -1) {
			hash = uri.replace(/.*#/, '#')
			uri = uri.replace(/#.*/, '')
		}
		var separator = uri.indexOf('?') !== -1 ? '&' : '?'
		return uri + separator + key + '=' + value + hash
	}
}

const getUrlForLink = (el) =>
	updateQueryStringParameter(
		el.href,
		'blocksy_prefix',
		el.closest('[data-prefix]').dataset.prefix
	)

const actuallyOpenForEl = (el) => {
	cachedFetch(getUrlForLink(el))
		.then((response) => response.text())
		.then((html) => {
			const div = document.createElement('div')

			div.innerHTML = html

			const entries = div.querySelector('.entries')

			if (!entries) {
				document.querySelector('.entries').innerHTML = ''
				return
			}

			markImagesAsLoaded(entries)

			setTimeout(() => {
				document.querySelector('.entries').innerHTML = entries.innerHTML
				;[...document.querySelectorAll('.entries > *')].map(
					(entryChild) => {
						if (entryChild.dataset.reveal) {
							return
						}

						entryChild.dataset.reveal = 'no'
					}
				)

				let currentPagination = document.querySelector('.ct-pagination')

				if (currentPagination && currentPagination.infiniteScroll) {
					currentPagination.infiniteScroll.destroy()
				}

				setTimeout(() => {
					if (currentPagination) {
						currentPagination.remove()
					}

					if (div.querySelector('.ct-pagination')) {
						document
							.querySelector('.entries')
							.after(div.querySelector('.ct-pagination'))
					}

					ctEvents.trigger('blocksy:frontend:init')
				})
			}, 200)

			if (!el.closest('.ct-posts-shortcode')) {
				history.pushState({}, '', el.href)
			}
		})
		.catch((err) => {
			console.warn('Something went wrong.', err)
		})
}

const store = {}

let pendingClicks = []

const flushPendingClicks = () => {
	;[...pendingClicks].map((el) => {
		if (store[getUrlForLink(el)]) {
			actuallyOpenForEl(el)
			pendingClicks = pendingClicks.filter((e) => e !== el)
		}
	})
}

const cachedFetch = (url) =>
	store[url]
		? new Promise((resolve) => {
				resolve(store[url])
				if (!window.ct_customizer_localizations) {
					store[url] = store[url].clone()
				}
		  })
		: new Promise((resolve) =>
				fetch(url).then((response) => {
					resolve(response)

					if (!window.ct_customizer_localizations) {
						store[url] = response.clone()
					}
				})
		  )

const preloadLink = (el) => {
	if (el.preloaded) {
		return
	}

	el.preloaded = true

	cachedFetch(getUrlForLink(el))
		.then((response) => response.text())
		.then(() => {
			flushPendingClicks()
		})
}

const fetchForEl = (el) => {
	if (el.classList.contains('active')) {
		return
	}

	el.closest('.ct-dynamic-filter')
		.querySelector('.active')
		.classList.remove('active')

	el.classList.add('active')

	if (store[getUrlForLink(el)]) {
		actuallyOpenForEl(el)
	} else {
		pendingClicks.push(el)
	}
}

registerDynamicChunk('blocksy_adv_cpt_filtering', {
	mount: (el, { event }) => {
		if (event.type !== 'click') {
			;[
				...document.querySelectorAll('.ct-dynamic-filter a'),
			].map((link) => preloadLink(link))

			return
		}

		fetchForEl(el)
	},
})

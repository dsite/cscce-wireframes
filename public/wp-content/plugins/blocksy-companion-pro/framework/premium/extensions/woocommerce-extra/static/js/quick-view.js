import $ from 'jquery'
import {
	registerDynamicChunk,
	getCurrentScreen,
	markImagesAsLoaded,
	loadStyle,
} from 'blocksy-frontend'
import ctEvents from 'ct-events'

const store = {}

const cachedFetch = (url) =>
	store[url]
		? new Promise((resolve) => {
				resolve(store[url])
				store[url] = store[url].clone()
		  })
		: new Promise((resolve) =>
				fetch(url).then((response) => {
					resolve(response)
					store[url] = response.clone()
				})
		  )

const openQuickViewFor = ({ e, el }) => {
	if (e.target.matches('.add_to_cart_button')) {
		return
	}

	if (e.target.matches('.added_to_cart')) {
		return
	}

	e.preventDefault()

	let productId = Array.from(el.classList)
		.find((className) => className.indexOf('post-') === 0)
		.split('-')[1]

	let href = `#quick-view-${productId}`

	if (document.querySelector(href)) {
		ctEvents.trigger('ct:overlay:handle-click', {
			e,
			href,
			options: {
				clickOutside: true,
			},
		})
		return
	}

	const loadingHtml = `
		<div id="quick-view-${productId}" data-behaviour="modal" class="ct-panel quick-view-modal">
			<span data-loader="circles">
				<span></span>
				<span></span>
				<span></span>
			</span>
		</div>
    `

	const div = document.createElement('div')

	div.innerHTML = loadingHtml

	document.body.appendChild(div.firstElementChild)
	const panel = document.querySelector(`#quick-view-${productId}`)

	requestAnimationFrame(() => {
		setTimeout(() => {
			if (panel) {
				panel.classList.add('active')
			}

			ctEvents.trigger('ct:overlay:handle-click', {
				e,
				href,
				options: {
					isModal: true,
					computeScrollContainer: () =>
						getCurrentScreen && getCurrentScreen() === 'mobile'
							? document.querySelector(href).firstElementChild
									.lastElementChild.lastElementChild
							: null,
					clickOutside: true,
					focus: false,
				},
			})

			Promise.all([
				new Promise((resolve) => {
					cachedFetch(
						`${ct_localizations.ajax_url}?action=blocsky_get_woo_quick_view&product_id=${productId}`
					).then((r) => {
						if (r.status === 200) {
							r.json().then(({ success, data }) => {
								if (!success) {
									return
								}
								resolve(data)
							})
						}
					})
				}),
			]).then(([data]) => {
				const div = document.createElement('div')

				div.innerHTML = data.quickview

				if (document.body.innerHTML.indexOf(data.body_html) === -1) {
					document.body.insertAdjacentHTML(
						'beforeend',
						data.body_html
					)
				}

				markImagesAsLoaded(div)

				if (document.querySelector(href)) {
					document.querySelector(href).innerHTML =
						div.firstElementChild.innerHTML
				}

				if ($) {
					;[
						...document.querySelectorAll(
							`${href} .variations_form`
						),
					].map((el) => $(el).wc_variation_form())
				}

				ctEvents.trigger('ct:custom-select:init')
				ctEvents.trigger('ct:custom-select-allow:init')

				ctEvents.trigger('blocksy:frontend:init')

				setTimeout(() => {
					if ($) {
						$.wcpaInit && $.wcpaInit()
					}
				}, 50)

				setTimeout(() => {
					setTimeout(() => {
						ctEvents.trigger('ct:overlay:handle-click', {
							e,
							href,
							options: {
								forceOpen: true,
								isModal: true,
								computeScrollContainer: () =>
									getCurrentScreen &&
									getCurrentScreen() === 'mobile'
										? document.querySelector(href)
												.firstElementChild
												.lastElementChild
												.lastElementChild
										: null,
								clickOutside: true,
								focus: false,
							},
						})
					})
					setTimeout(() => ctEvents.trigger('ct:flexy:update'))
				}, 100)
			})
		})
	})
}

registerDynamicChunk('blocksy_ext_woo_extra_quick_view', {
	mount: (el, { event }) => {
		const maybeMatchingContainer = ct_localizations.dynamic_styles_selectors.find(
			(descriptor) => descriptor.selector === '.ct-panel'
		)

		loadStyle(maybeMatchingContainer.url, true).then(() => {
			if (el.closest('[data-quick-view="card"]')) {
				openQuickViewFor({ e: event, el })
				return
			}

			openQuickViewFor({ e: event, el: el.closest('.product') })
		})
	},
})

ctEvents.on('ct:modal:closed', (modalContainer) => {
	if (!modalContainer.closest('.quick-view-modal')) {
		return
	}

	if (modalContainer.querySelector('.flexy-container')) {
		const flexyEl = modalContainer.querySelector('.flexy-container')
			.parentNode

		flexyEl.flexy && flexyEl.flexy.destroy && flexyEl.flexy.destroy()
	}

	setTimeout(() => {
		modalContainer.remove()
	})
})

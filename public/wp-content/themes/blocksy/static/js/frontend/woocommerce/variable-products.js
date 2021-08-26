import $ from 'jquery'
import ctEvents from 'ct-events'
import { markImagesAsLoaded } from '../lazy-load-helpers'

let originalImageUpdate = null

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

const makeUrlFor = ({ variation, productId, isQuickView }) => {
	let url = new URL(ct_localizations.ajax_url)
	let params = new URLSearchParams(url.search.slice(1))

	params.append('action', 'blocksy_get_product_view_for_variation')
	params.append('variation_id', variation.variation_id)
	params.append('product_id', productId)
	params.append('is_quick_view', isQuickView)

	url.search = `?${params.toString()}`

	return url.toString()
}

export const mount = (el) => {
	if (!$ || !$.fn || !$.fn.wc_variations_image_update) {
		return
	}

	originalImageUpdate = $.fn.wc_variations_image_update

	$.fn.wc_variations_image_update = function (variation) {
		const currentVariation = el
			.closest('.product')
			.querySelector('.woocommerce-product-gallery')

		let productContainer = currentVariation.closest('.type-product')

		let isQuickView = 'no'

		let productId = productContainer.id.replace('product-', '')

		if (!productId) {
			productId = currentVariation
				.closest('[class*="ct-quick-view"]')
				.querySelector('[data-product_id]').dataset.product_id

			if (productId) {
				isQuickView = 'yes'
			}
		}

		const allVariations = JSON.parse(el.dataset.product_variations)

		let nextVariationObj = false
		let currentVariationObj = false
		let currentVariationIsDefault = false

		if (allVariations) {
			nextVariationObj = variation.variation_id
				? allVariations.find(
						({ variation_id }) =>
							parseInt(variation_id) ===
							parseInt(variation.variation_id)
				  )
				: false
			currentVariationObj = currentVariation.dataset.currentVariation
				? allVariations.find(
						({ variation_id }) =>
							parseInt(variation_id) ===
							parseInt(currentVariation.dataset.currentVariation)
				  )
				: false

			currentVariationIsDefault =
				currentVariation.querySelector('.flexy-items') &&
				(!currentVariationObj ||
					(currentVariationObj &&
						currentVariation.querySelector(
							`.flexy-items [srcset*="${currentVariationObj.image.src}"]`
						) &&
						currentVariationObj.blocksy_gallery_source ===
							'default' &&
						[
							...currentVariation.querySelector('.flexy-items')
								.children,
						].indexOf(
							currentVariation
								.querySelector(
									`.flexy-items [srcset*="${currentVariationObj.image.src}"]`
								)
								.closest('div')
						) > 0))
		}

		if (
			!variation.variation_id &&
			!currentVariation.dataset.currentVariation
		) {
			return
		}

		if (
			parseInt(variation.variation_id) ===
			parseInt(currentVariation.dataset.currentVariation)
		) {
			return
		}

		if (variation.variation_id) {
			currentVariation.dataset.currentVariation = variation.variation_id
		} else {
			currentVariation.removeAttribute('data-current-variation')
		}

		if (currentVariationObj && nextVariationObj) {
			if (
				nextVariationObj.blocksy_gallery_source === 'default' &&
				currentVariationObj.blocksy_gallery_source === 'default' &&
				nextVariationObj.image_id === currentVariationObj.image_id
			) {
				return
			}
		}

		if (
			allVariations &&
			currentVariation.querySelector('[data-flexy]') &&
			currentVariationIsDefault &&
			(!nextVariationObj ||
				nextVariationObj.blocksy_gallery_source === 'default')
		) {
			let maybePillImage = null
			let pillIndex = 0

			if (variation) {
				maybePillImage = currentVariation.querySelector(
					`.flexy-items [srcset*="${variation.image.src}"]`
				)

				if (maybePillImage) {
					pillIndex = [
						...currentVariation.querySelector(`.flexy-items`)
							.children,
					].indexOf(maybePillImage.closest('div'))
				}
			}

			const pill = currentVariation.querySelector(`.flexy-pills > *`)
				.children[pillIndex]

			if ((!variation || (variation && maybePillImage)) && pill) {
				if (
					currentVariation
						.querySelector('[data-flexy]')
						.dataset.flexy.indexOf('no') > -1
				) {
					if (
						currentVariation.querySelector('[data-flexy]')
							.forcedMount
					) {
						currentVariation
							.querySelector('[data-flexy]')
							.forcedMount()
					}

					setTimeout(() => {
						pill.click()
					}, 500)

					return
				} else {
					pill.click()
					return
				}
			}
		}

		const acceptHtml = (html) => {
			const div = document.createElement('div')
			div.innerHTML = html

			currentVariation.innerHTML = div.firstElementChild.innerHTML

			markImagesAsLoaded(currentVariation)

			currentVariation.hasLazyLoadClickHoverListener = false

			setTimeout(() => {
				ctEvents.trigger('blocksy:frontend:init')
				currentVariation.removeAttribute('data-state')
			})
		}

		if (variation.blocksy_gallery_html) {
			acceptHtml(variation.blocksy_gallery_html)
			return
		}

		currentVariation.removeAttribute('style')
		requestAnimationFrame(() => {
			currentVariation.dataset.state = 'loading'
		})

		let maybeLoadedVariation = allVariations
			? allVariations.find(
					(nestedVariation) =>
						store[
							makeUrlFor({
								variation: nestedVariation,
								productId,
								isQuickView,
							})
						] &&
						nestedVariation.image_id === variation.image_id &&
						variation.blocksy_gallery_source === 'default' &&
						nestedVariation.blocksy_gallery_source === 'default'
			  )
			: null

		cachedFetch(
			makeUrlFor({
				variation: maybeLoadedVariation || variation,
				productId,
				isQuickView,
			}),
			{
				method: 'POST',
			}
		)
			.then((response) => response.json())
			.then(({ success, data }) => {
				if (!success) {
					return
				}

				acceptHtml(data.html)
			})
	}
}

import './variables'
import ctEvents from 'ct-events'

import { checkAndReplace, responsiveClassesFor } from 'blocksy-customizer-sync'

wp.customize('floatingBarTitleVisibility', (val) =>
	val.bind((to) => {
		responsiveClassesFor(
			'floatingBarTitleVisibility',
			document.querySelector('.ct-floating-bar .ct-item-title')
		)
	})
)

wp.customize('floatingBarVisibility', (val) =>
	val.bind((to) => {
		responsiveClassesFor(
			'floatingBarVisibility',
			document.querySelector('.ct-floating-bar')
		)
	})
)

wp.customize('filter_panel_position', (val) => {
	val.bind((to) => {
		const el = document.querySelector('#woo-filters-panel')

		ctEvents.trigger('ct:offcanvas:force-close', {
			container: el,
		})

		setTimeout(() => {
			el.removeAttribute('data-behaviour')
			el.classList.add('ct-no-transition')

			requestAnimationFrame(() => {
				el.dataset.behaviour = `${to}-side`

				setTimeout(() => {
					el.classList.remove('ct-no-transition')
				})
			})
		}, 300)
	})
})

wp.customize('woocommerce_filter_visibility', (val) => {
	val.bind((to) => {
		responsiveClassesFor(
			'woocommerce_filter_visibility',
			document.querySelector('.ct-filter-trigger')
		)
	})
})

wp.customize('single_page_share_box_visibility', (val) => {
	val.bind((to) => {
		responsiveClassesFor(
			'single_page_share_box_visibility',
			document.querySelector('[data-prefix="single_page"] .ct-share-box')
		)
	})
})

import { __ } from 'ct-i18n'
import { createElement, render } from '@wordpress/element'
import { onDocumentLoaded } from 'blocksy-options'
import $ from 'jquery'
import SettingsManager from './SettingsManager'

onDocumentLoaded(() => {
	const allDynamicSidebars = [
		...document.querySelectorAll(
			'.widgets-holder-wrap:not(.inactive-sidebar) [id*="ct-dynamic-sidebar"] .sidebar-description > .description'
		),
	]

	allDynamicSidebars.map((el) => {
		el.parentNode.insertAdjacentHTML(
			'beforebegin',
			'<div class="blocksy-settings"></div>'
		)

		el.classList.add('ct-tooltip-top')
	})

	if (allDynamicSidebars.length > 0) {
		const div = document.createElement('div')
		document.body.appendChild(div)

		render(<SettingsManager />, div)
	}
})

$(document).on('submit', '.ct-sidebars-manager form', (e) => {
	e.preventDefault()

	let input = document.querySelector('.ct-sidebars-manager form input')

	if (!input.value) return

	wp.ajax
		.send({
			url: `${wp.ajax.settings.url}?action=blocksy_sidebars_create&name=${input.value}`,
			contentType: 'application/json',
		})
		.then(() => location.reload())
})

$(document).on('input', '.ct-sidebars-manager form input', (e) => {
	e.preventDefault()

	let input = document.querySelector('.ct-sidebars-manager form input')

	let button = document.querySelector('.ct-sidebars-manager form button')

	if (input.value) {
		button.removeAttribute('disabled')
	} else {
		button.setAttribute('disabled', true)
	}
})

$(document).on(
	'click.ctDynamicSidebars',
	'[id*="ct-dynamic-sidebar"] .sidebar-description',
	function (e) {
		e.preventDefault()

		if (
			$(this).closest('.sidebar-description').length === 0 ||
			!$(this).hasClass('sidebar-description')
		) {
			return
		}

		wp.ajax
			.send({
				url: `${
					wp.ajax.settings.url
				}?action=blocksy_sidebars_remove&id=${$(this)
					.closest('.widgets-sortables')[0]
					.id.replace('ct-dynamic-sidebar-', '')}`,
				contentType: 'application/json',
			})
			.then(() => location.reload())
	}
)

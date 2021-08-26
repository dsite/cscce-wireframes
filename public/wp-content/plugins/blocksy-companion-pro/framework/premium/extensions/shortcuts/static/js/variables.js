import { handleVariablesFor } from 'customizer-sync-helpers'
import {
	handleBackgroundOptionFor,
	responsiveClassesFor,
	typographyOption,
} from 'blocksy-customizer-sync'

handleVariablesFor({
	shortcuts_container_height: {
		selector: ':root',
		variable: 'shortcuts-container-height',
		responsive: true,
		unit: 'px',
	},

	shortcuts_container_width: {
		selector: ':root',
		variable: 'shortcuts-container-width',
		unit: '',
	},

	shortcuts_icon_size: {
		selector: '.ct-shortcuts-container',
		variable: 'icon-size',
		responsive: true,
		unit: 'px',
	},

	...typographyOption({
		id: 'shortcuts_font',
		selector: '.ct-shortcuts-container',
	}),

	shortcuts_font_color: [
		{
			selector: '.ct-shortcuts-container a',
			variable: 'linkInitialColor',
			type: 'color:default',
			responsive: true,
		},

		{
			selector: '.ct-shortcuts-container a',
			variable: 'linkHoverColor',
			type: 'color:hover',
			responsive: true,
		},
	],

	shortcuts_icon_color: [
		{
			selector: '.ct-shortcuts-container',
			variable: 'icon-color',
			type: 'color:default',
			responsive: true,
		},

		{
			selector: '.ct-shortcuts-container',
			variable: 'icon-hover-color',
			type: 'color:hover',
			responsive: true,
		},
	],

	shortcuts_divider: {
		selector: '.ct-shortcuts-container',
		variable: 'shortcuts-divider',
		type: 'border',
	},

	shortcuts_divider_height: [
		{
			selector: '.ct-shortcuts-container',
			variable: 'shortcuts-divider-height',
			unit: '%',
		},
	],

	...handleBackgroundOptionFor({
		id: 'shortcuts_container_background',
		selector: '.ct-shortcuts-container',
		responsive: true,
	}),

	shortcuts_container_shadow: {
		selector: '.ct-shortcuts-container',
		type: 'box-shadow',
		variable: 'box-shadow',
		responsive: true,
	},

	shortcuts_container_border_radius: {
		selector: '.ct-shortcuts-container',
		type: 'spacing',
		variable: 'border-radius',
		responsive: true
	}
})

wp.customize('shortcuts_bar_visibility', (value) =>
	value.bind((to) =>
		responsiveClassesFor(
			'shortcuts_bar_visibility',
			document.querySelector('.ct-shortcuts-container')
		)
	)
)

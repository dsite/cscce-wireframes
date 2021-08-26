import './variables'

wp.customize('shortcuts_bar_type', (val) => {
	val.bind((to) => {
		let maybeShortcuts = document.querySelector('.ct-shortcuts-container')

		if (maybeShortcuts) {
			maybeShortcuts.dataset.type = to
		}
	})
})

wp.customize('shortcuts_label_position', (val) => {
	val.bind((to) => {
		;[...document.querySelectorAll('.ct-shortcuts-container a')].map(
			(a) => {
				a.dataset.label = to
			}
		)
	})
})

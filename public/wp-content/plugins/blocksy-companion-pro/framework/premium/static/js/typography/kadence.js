import { __ } from 'ct-i18n'

export const mountKadenceFontsIntegration = () => {
	let fontsData = null

	const fetchFontsList = async () => {
		const body = new FormData()

		body.append('action', 'blocksy_get_fonts_list')

		try {
			const response = await fetch(ajaxurl, {
				method: 'POST',
				body,
			})

			if (response.status === 200) {
				const {
					success,
					data: { fonts },
				} = await response.json()

				if (success) {
					fontsData = fonts
				}
			}
		} catch (e) {}
	}

	fetchFontsList()

	wp.hooks.addFilter('kadence.typography_options', 'blocksy', (options) => {
		if (!fontsData) {
			return options
		}

		Object.values(fontsData)
			.filter(({ type }) => type !== 'system' && type !== 'google')
			.map(({ type, families }) => {
				let titles = {
					'local-google-fonts': __(
						'Blocksy Local Google Fonts',
						'blc'
					),
					typekit: __('Blocksy Typekit', 'blc'),
					file: __('Blocksy Custom Fonts', 'blc'),
				}

				if (
					!options.some((option) => option.id === `blocksy-${type}`)
				) {
					options.unshift({
						type: 'group',
						id: `blocksy-${type}`,
						label: titles[type],
						options: families.map(({ display, family }) => ({
							label: display,
							value: family.replace('ct_typekit_', ''),
							google: false,
						})),
					})
				}
			})

		if (!fontsData.google) {
			options = options.filter(({ label }) => label !== 'Google Fonts')
		}

		return options
	})
}

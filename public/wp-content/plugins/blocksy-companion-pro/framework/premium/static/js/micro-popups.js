import ctEvents from 'ct-events'
import { registerDynamicChunk } from 'blocksy-frontend'

const closeMicroPopup = (popup) => {
	let pastPopups = JSON.parse(
		localStorage.getItem('blocksyPastPopups') || '[]'
	)

	let newPastPopups = [...pastPopups, popup.id.replace('ct-popup-', '')]

	localStorage.setItem(
		'blocksyPastPopups',
		JSON.stringify([...new Set(newPastPopups)])
	)

	popup.classList.toggle('active')
}

const openMicroPopup = (popup) => {
	let isOpen = popup.classList.contains('active')

	popup.classList.toggle('active')

	if (!isOpen) {
		let maybeClose = popup.querySelector('.ct-close-button')

		if (maybeClose && !maybeClose.hasClickListener) {
			maybeClose.hasClickListener = true

			popup
				.querySelector('.ct-close-button')
				.addEventListener('click', (e) => {
					e.preventDefault()
					closeMicroPopup(popup)
				})
		}

		if (popup.dataset.popupBackdrop === 'yes' && !popup.hasClickListener) {
			popup.hasClickListener = true
			popup.addEventListener('click', (e) => {
				if (e.target.dataset.popupBackdrop === 'yes') {
					e.preventDefault()
					closeMicroPopup(popup)
				}
			})
		}
	}
}

let isPopupExpired = (popup) => {
	let popupId = popup.id.replace('ct-popup-', '')

	if (popup.dataset.popupMode.indexOf('once') === -1) {
		return false
	}

	let pastPopups = JSON.parse(
		localStorage.getItem('blocksyPastPopups') || '[]'
	)

	return pastPopups.indexOf(popupId) > -1
}

let mounted = false

registerDynamicChunk('blocksy_pro_micro_popups', {
	mount: (el) => {
		if (!mounted) {
			mounted = true
			;[...document.querySelectorAll('[data-popup-mode*="page_load"]')]
				.filter((popup) => !isPopupExpired(popup))
				.map((popup) => openMicroPopup(popup))
			;[...document.querySelectorAll('[data-popup-mode*="after_x_time"]')]
				.filter((popup) => !isPopupExpired(popup))
				.map((popup) => {
					let timeout = popup.dataset.popupMode.split(':')[1]

					setTimeout(() => {
						openMicroPopup(popup)
					}, parseInt(timeout, 10) * 1000)
				})
			if (document.querySelector('[data-popup-mode*="exit_intent"]')) {
				let allPopupsWithExit = [
					...document.querySelectorAll(
						'[data-popup-mode*="exit_intent"]'
					),
				].filter((popup) => !isPopupExpired(popup))

				if (allPopupsWithExit.length > 0) {
					document.addEventListener('mouseout', (event) => {
						if (
							event.clientY <= 0 ||
							event.clientX <= 0 ||
							event.clientX >= window.innerWidth ||
							event.clientY >= window.innerHeight
						) {
							;[
								...document.querySelectorAll(
									'[data-popup-mode*="exit_intent"]'
								),
							].map((popup) => {
								if (popup.classList.contains('active')) {
									return
								}

								openMicroPopup(popup)
							})
						}
					})
				}
			}

			if (document.querySelector('[data-popup-mode*="element_reveal"]')) {
				;[
					...document.querySelectorAll(
						'[data-popup-mode*="element_reveal"]'
					),
				]
					.filter((popup) => !isPopupExpired(popup))
					.map((popup) => {
						let selector = popup.dataset.popupMode.split(':')[1]

						if (!document.querySelector(selector)) {
							return
						}

						let io = new IntersectionObserver((entries) => {
							const visible = entries
								.filter(({ isIntersecting }) => isIntersecting)
								.map(({ target }) => target)

							if (visible.length === 0) {
								return
							}

							openMicroPopup(popup)

							io.disconnect()
						})

						;[...document.querySelectorAll(selector)].map((el) => {
							io.observe(el)
						})
					})
			}

			if (
				document.querySelector('[data-popup-mode*="after_inactivity"]')
			) {
				;[
					...document.querySelectorAll(
						'[data-popup-mode*="after_inactivity"]'
					),
				]
					.filter((popup) => !isPopupExpired(popup))
					.map((popup) => {
						var t
						window.addEventListener('load', resetTimer)
						window.addEventListener('mousemove', resetTimer)
						window.addEventListener('mousedown', resetTimer)
						window.addEventListener('touchstart', resetTimer)
						window.addEventListener('click', resetTimer)
						window.addEventListener('keydown', resetTimer)
						window.addEventListener('scroll', resetTimer, true)

						function yourFunction() {
							openMicroPopup(popup)

							if (t) {
								clearTimeout(t)
							}

							window.removeEventListener('load', resetTimer)
							window.removeEventListener('mousemove', resetTimer)
							window.removeEventListener('mousedown', resetTimer)
							window.removeEventListener('touchstart', resetTimer)
							window.removeEventListener('click', resetTimer)
							window.removeEventListener('keydown', resetTimer)
							window.removeEventListener(
								'scroll',
								resetTimer,
								true
							)
						}

						function resetTimer() {
							let timeout = popup.dataset.popupMode.split(':')[1]
							clearTimeout(t)

							t = setTimeout(
								yourFunction,
								parseInt(timeout, 10) * 1000
							)
						}
					})
			}

			if (document.querySelector('[data-popup-mode*="scroll"]')) {
				;[...document.querySelectorAll('[data-popup-mode*="scroll"]')]
					.filter((popup) => !isPopupExpired(popup))
					.map((popup) => {
						let isUp = popup.dataset.popupMode.indexOf('up') > -1

						let currentScrollY = scrollY

						const cb = () => {
							let scrollOffset = popup.dataset.popupMode.split(
								':'
							)[1]

							if (scrollOffset.indexOf('px') > -1) {
								scrollOffset = parseFloat(scrollOffset)
							}

							if (scrollOffset.toString().indexOf('%') > -1) {
								let body = document.body
								let html = document.documentElement

								let height = Math.max(
									body.scrollHeight,
									body.offsetHeight,
									html.clientHeight,
									html.scrollHeight,
									html.offsetHeight
								)

								scrollOffset =
									(parseFloat(scrollOffset) / 100) * height
							}

							if (scrollOffset.toString().indexOf('vh') > -1) {
								scrollOffset =
									(parseFloat(scrollOffset) / 100) *
									innerHeight
							}

							if (isUp) {
								if (scrollY > currentScrollY) {
									currentScrollY = scrollY
								} else {
									if (
										Math.abs(currentScrollY - scrollY) >
										scrollOffset
									) {
										openMicroPopup(popup)
										window.removeEventListener(
											'scroll',
											cb,
											true
										)
									}
								}
							} else {
								if (scrollOffset <= scrollY) {
									openMicroPopup(popup)
									window.removeEventListener(
										'scroll',
										cb,
										true
									)
								}
							}
						}

						window.addEventListener('scroll', cb, true)
					})
			}
		}

		;[...document.querySelectorAll('[href*="ct-popup-"]')].map(
			(popupTrigger) => {
				if (popupTrigger.hasClickListener) {
					return
				}

				if (
					!document.querySelector(popupTrigger.getAttribute('href'))
				) {
					return
				}

				popupTrigger.hasClickListener = true

				popupTrigger.addEventListener('click', (e) => {
					e.preventDefault()

					let popup = document.querySelector(
						popupTrigger.getAttribute('href')
					)

					openMicroPopup(popup)
				})
			}
		)
	},
})

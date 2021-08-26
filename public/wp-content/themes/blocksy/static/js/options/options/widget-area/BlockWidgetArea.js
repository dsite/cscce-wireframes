import { createElement, useEffect, useRef } from '@wordpress/element'
import $ from 'jquery'

const BlockWidgetArea = ({
	value,
	option,
	option: { sidebarId = 'ct-footer-sidebar-1' },
	onChange,
}) => {
	const parentEl = useRef()

	useEffect(() => {
		let sidebarForCleanup = 'ct-footer-sidebar-1'

		if (sidebarId === 'ct-footer-sidebar-1') {
			sidebarForCleanup = 'ct-footer-sidebar-2'
		}

		const controlForSidebarId =
			wp.customize.control._value[`sidebars_widgets[${sidebarId}]`]

		wp.customize.control._value[
			`sidebars_widgets[${sidebarForCleanup}]`
		].subscribers.forEach((c) => {
			c(true)
		})

		requestAnimationFrame(() => {
			controlForSidebarId.subscribers.forEach((c) => {
				c(true)
			})
		})

		controlForSidebarId.oldContainer = controlForSidebarId.container

		controlForSidebarId.container = $(parentEl.current)

		return () => {
			controlForSidebarId.container = controlForSidebarId.oldContainer
		}
	}, [])

	return <div className="ct-option-widget-area" ref={parentEl}></div>
}

export default BlockWidgetArea

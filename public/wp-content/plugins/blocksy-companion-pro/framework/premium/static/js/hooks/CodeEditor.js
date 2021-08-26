import ctEvents from 'ct-events'
import { useState, render, createElement, Fragment } from '@wordpress/element'

import classnames from 'classnames'

import { Overlay } from 'blocksy-options'

import { subscribe, dispatch } from '@wordpress/data'
import { __ } from 'ct-i18n'
import { createBlock } from '@wordpress/blocks'

const CodeEditorTrigger = () => {
	const [isEditing, setIsEditing] = useState(false)

	return (
		<Fragment>
			<button
				onClick={(e) => {
					e.preventDefault()
					setIsEditing(true)
				}}
				type="button"
				className="button button-primary button-large">
				<span className="disabled">{__('Use code editor', 'blc')}</span>
				<span className="enabled">{__('Exit code editor', 'blc')}</span>
			</button>

			<Overlay
				items={isEditing}
				className="ct-admin-modal ct-hooks-notice-modal"
				onDismiss={() => {
					setIsEditing(false)
				}}
				render={() => (
					<div className="ct-modal-content">
						<h2>{__('Heads up!', 'blc')}</h2>
						<p>
							{__(
								'Enabling & disabling the code editor will erase everything from your post editor and this action is irreversible.',
								'blc'
							)}
						</p>
						<p>
							<b>
								{__(
									'Are you sure you want to continue?',
									'blc'
								)}
							</b>
						</p>

						<div
							className="ct-modal-actions has-divider "
							data-buttons="2">
							<button
								className={classnames('button ct-large-button')}
								onClick={() => {
									setIsEditing(false)
								}}>
								{__('Cancel', 'blc')}
							</button>

							<button
								className={classnames('button-primary')}
								onClick={() => {
									setIsEditing(false)

									const isEnabled = document.body.classList.contains(
										'blocksy-inline-code-editor'
									)
									const { resetBlocks } = dispatch(
										'core/block-editor'
									)

									document.body.classList.remove(
										'blocksy-inline-code-editor'
									)

									if (!isEnabled) {
										document.body.classList.add(
											'blocksy-inline-code-editor'
										)
									}

									if (isEnabled) {
										resetBlocks([])
									} else {
										resetBlocks([createBlock('core/code')])
									}

									ctEvents.trigger(
										'ct:metabox:options:trigger-change',
										{
											id: 'has_inline_code_editor',
											value: isEnabled ? 'no' : 'yes',
										}
									)

									wp.data
										.dispatch('core/block-editor')
										.updateSettings({
											templateLock: !isEnabled,
										})
								}}>
								{__('Yes, continue', 'blc')}
							</button>
						</div>
					</div>
				)}
			/>
		</Fragment>
	)
}

export const mountCodeEditor = () => {
	if (!wp.data.dispatch('core/block-editor')) {
		return
	}

	if (!document.body.classList.contains('post-type-ct_content_block')) {
		return
	}

	const isEnabled = document.body.classList.contains(
		'blocksy-inline-code-editor'
	)

	wp.data.dispatch('core/block-editor').updateSettings({
		templateLock: isEnabled,
	})

	subscribe(function () {
		setTimeout(function () {
			const editorToolbar = document.querySelector(
				'#editor .edit-post-header__toolbar'
			)

			if (
				editorToolbar &&
				!editorToolbar.querySelector('.blocksy-code-editor-trigger')
			) {
				editorToolbar.insertAdjacentHTML(
					'beforeend',
					`<div class="blocksy-code-editor-trigger"></div>`
				)

				setTimeout(() => {
					render(
						<CodeEditorTrigger />,
						editorToolbar.querySelector(
							'.blocksy-code-editor-trigger'
						)
					)
				})
			}
		}, 1)
	})
}

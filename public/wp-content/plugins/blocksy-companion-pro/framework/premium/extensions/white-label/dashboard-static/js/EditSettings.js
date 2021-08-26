import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment,
} from '@wordpress/element'
import ctEvents from 'ct-events'

import classnames from 'classnames'
import { __, sprintf } from 'ct-i18n'
import { Switch } from 'blocksy-options'
import Overlay from '../../../../../../static/js/helpers/Overlay'

let whiteLabelSettingsCache = {
	locked: false,
	hide_demos: false,

	author: {
		name: '',
		url: '',
		support: '',
	},

	theme: {
		name: '',
		description: '',
		screenshot: '',
	},

	plugin: {
		name: '',
		description: '',
		thumbnail: '',
	},
}

const EditSettings = () => {
	const [isEditing, setIsEditing] = useState(false)

	// agency | theme | plugin | null
	const [openView, setOpenView] = useState(null)

	// details | advanced
	const [currentTab, setCurrentTab] = useState('details')

	const [whiteLabelSettings, setWhiteLabelSettings] = useState(
		whiteLabelSettingsCache
	)

	const loadData = async () => {
		const body = new FormData()
		body.append('action', 'blocksy_get_white_label_settings')

		try {
			const response = await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body,
			})

			if (response.status === 200) {
				const { success, data } = await response.json()

				if (success) {
					whiteLabelSettingsCache = data.settings
					setWhiteLabelSettings(data.settings)
				}
			}
		} catch (e) {}
	}

	const saveWhiteLabelSettings = () => {
		wp.ajax
			.send({
				url: `${wp.ajax.settings.url}?action=blocksy_update_white_label_settings`,
				contentType: 'application/json',
				data: JSON.stringify(whiteLabelSettings),
			})
			.then(() => {
				location.reload()
				setIsEditing(false)
			})
	}

	useEffect(() => {
		loadData()
	}, [])

	return (
		<Fragment>
			<button
				className="ct-button ct-config-btn"
				data-button="white"
				title={__('Edit Settings', 'blc')}
				onClick={() => setIsEditing(true)}>
				{__('Configure', 'blc')}
			</button>

			<Overlay
				items={isEditing}
				onDismiss={() => setIsEditing(false)}
				className={'ct-whitelabel-modal'}
				render={() => (
					<div className={classnames('ct-modal-content')}>
						<h2>{__('White Label Settings', 'blc')}</h2>

						<p>
							{__(
								'Remove any link that points to Blocksy website and change the dashboard identity. These options are mostly used by agencies and developers who are building websites for clients.',
								'blc'
							)}
						</p>

						<div className="ct-options-container ct-tabs-scroll">
							<div className={classnames('ct-tabs')}>
								<ul>
									{['details', 'advanced'].map((tab) => (
										<li
											key={tab}
											className={classnames({
												active: tab === currentTab,
											})}
											onClick={() => setCurrentTab(tab)}>
											{
												{
													details: __(
														'General',
														'blc'
													),
													advanced: __(
														'Advanced',
														'blc'
													),
												}[tab]
											}
										</li>
									))}
								</ul>

								<div className="ct-current-tab">
									{currentTab === 'details' &&
										[
											{
												key: 'agency',
												title: __(
													'Agency Details',
													'blc'
												),
												content: () => (
													<Fragment>
														<div className="half-size">
															<label>
																{__(
																	'Agency Name',
																	'blc'
																)}
															</label>
															<input
																type="text"
																value={
																	whiteLabelSettings
																		.author
																		.name
																}
																onChange={({
																	target: {
																		value: name,
																	},
																}) => {
																	setWhiteLabelSettings(
																		{
																			...whiteLabelSettings,
																			author: {
																				...whiteLabelSettings.author,
																				name,
																			},
																		}
																	)
																}}
															/>
														</div>
														<div className="half-size">
															<label>
																{__(
																	'Agency URL',
																	'blc'
																)}
															</label>
															<input
																type="text"
																value={
																	whiteLabelSettings
																		.author
																		.url
																}
																onChange={({
																	target: {
																		value: url,
																	},
																}) => {
																	setWhiteLabelSettings(
																		{
																			...whiteLabelSettings,
																			author: {
																				...whiteLabelSettings.author,
																				url,
																			},
																		}
																	)
																}}
															/>
														</div>
														<div>
															<label>
																{__(
																	'Agency Support/Contact Form URL',
																	'blc'
																)}
															</label>
															<input
																type="text"
																value={
																	whiteLabelSettings
																		.author
																		.support
																}
																onChange={({
																	target: {
																		value: support,
																	},
																}) => {
																	setWhiteLabelSettings(
																		{
																			...whiteLabelSettings,
																			author: {
																				...whiteLabelSettings.author,
																				support,
																			},
																		}
																	)
																}}
															/>
														</div>
													</Fragment>
												),
											},

											{
												key: 'theme',
												title: __(
													'Theme Details',
													'blc'
												),
												content: () => (
													<Fragment>
														<div>
															<label>
																{__(
																	'Theme Name',
																	'blc'
																)}
															</label>
															<input
																type="text"
																value={
																	whiteLabelSettings
																		.theme
																		.name
																}
																onChange={({
																	target: {
																		value: name,
																	},
																}) => {
																	setWhiteLabelSettings(
																		{
																			...whiteLabelSettings,
																			theme: {
																				...whiteLabelSettings.theme,
																				name,
																			},
																		}
																	)
																}}
															/>
														</div>
														<div>
															<label>
																{__(
																	'Theme Description',
																	'blc'
																)}
															</label>
															<textarea
																value={
																	whiteLabelSettings
																		.theme
																		.description
																}
																onChange={({
																	target: {
																		value: description,
																	},
																}) => {
																	setWhiteLabelSettings(
																		{
																			...whiteLabelSettings,
																			theme: {
																				...whiteLabelSettings.theme,
																				description,
																			},
																		}
																	)
																}}
															/>
														</div>

														<div>
															<label>
																{__(
																	'Theme Screenshot URL',
																	'blc'
																)}
															</label>

															<div className="ct-upload-thumb">
																<input
																	type="text"
																	value={
																		whiteLabelSettings
																			.theme
																			.screenshot
																	}
																	onChange={({
																		target: {
																			value: screenshot,
																		},
																	}) => {
																		setWhiteLabelSettings(
																			{
																				...whiteLabelSettings,
																				theme: {
																					...whiteLabelSettings.theme,
																					screenshot,
																				},
																			}
																		)
																	}}
																/>

																<button
																	className="button"
																	onClick={() => {
																		let frame = wp.media(
																			{
																				button: {
																					text:
																						'Select',
																				},
																				states: [
																					new wp.media.controller.Library(
																						{
																							title:
																								'Select logo',
																							library: wp.media.query(
																								{
																									type:
																										'image',
																								}
																							),
																							multiple: false,
																							date: false,
																							priority: 20,
																						}
																					),
																				],
																			}
																		)

																		frame
																			.setState(
																				'library'
																			)
																			.open()

																		frame.on(
																			'select',
																			() => {
																				var attachment = frame
																					.state()
																					.get(
																						'selection'
																					)
																					.first()
																					.toJSON()

																				setWhiteLabelSettings(
																					{
																						...whiteLabelSettings,
																						theme: {
																							...whiteLabelSettings.theme,
																							screenshot:
																								attachment.url,
																						},
																					}
																				)
																			}
																		)
																	}}>
																	{__(
																		'Choose File',
																		'blc'
																	)}
																</button>

																<span>
																	{__(
																		'You can insert the link to a self hosted image or upload one. The recommended image size is 1200px wide by 900px tall.',
																		'blc'
																	)}
																</span>
															</div>
														</div>

														<div>
															<label>
																{__(
																	'Theme Icon URL',
																	'blc'
																)}
															</label>

															<div className="ct-upload-thumb">
																<input
																	type="text"
																	value={
																		whiteLabelSettings
																			.theme
																			.icon
																	}
																	onChange={({
																		target: {
																			value: icon,
																		},
																	}) => {
																		setWhiteLabelSettings(
																			{
																				...whiteLabelSettings,
																				theme: {
																					...whiteLabelSettings.theme,
																					icon,
																				},
																			}
																		)
																	}}
																/>

																<button
																	className="button"
																	onClick={() => {
																		let frame = wp.media(
																			{
																				button: {
																					text:
																						'Select',
																				},
																				states: [
																					new wp.media.controller.Library(
																						{
																							title:
																								'Select logo',
																							library: wp.media.query(
																								{
																									type:
																										'image',
																								}
																							),
																							multiple: false,
																							date: false,
																							priority: 20,
																						}
																					),
																				],
																			}
																		)

																		frame
																			.setState(
																				'library'
																			)
																			.open()

																		frame.on(
																			'select',
																			() => {
																				var attachment = frame
																					.state()
																					.get(
																						'selection'
																					)
																					.first()
																					.toJSON()

																				setWhiteLabelSettings(
																					{
																						...whiteLabelSettings,
																						theme: {
																							...whiteLabelSettings.theme,
																							icon:
																								attachment.url,
																						},
																					}
																				)
																			}
																		)
																	}}>
																	{__(
																		'Choose File',
																		'blc'
																	)}
																</button>

																<span>
																	{__(
																		'You can insert the link to a self hosted image or upload one. The recommended image size is 18px wide by 18px tall.',
																		'blc'
																	)}
																</span>
															</div>
														</div>
													</Fragment>
												),
											},

											{
												key: 'plugin',
												title: __(
													'Plugin Details',
													'blc'
												),
												content: () => (
													<Fragment>
														<div>
															<label>
																{__(
																	'Plugin Name',
																	'blc'
																)}
															</label>
															<input
																type="text"
																value={
																	whiteLabelSettings
																		.plugin
																		.name
																}
																onChange={({
																	target: {
																		value: name,
																	},
																}) => {
																	setWhiteLabelSettings(
																		{
																			...whiteLabelSettings,
																			plugin: {
																				...whiteLabelSettings.plugin,
																				name,
																			},
																		}
																	)
																}}
															/>
														</div>
														<div>
															<label>
																{__(
																	'Plugin Description',
																	'blc'
																)}
															</label>
															<textarea
																value={
																	whiteLabelSettings
																		.plugin
																		.description
																}
																onChange={({
																	target: {
																		value: description,
																	},
																}) => {
																	setWhiteLabelSettings(
																		{
																			...whiteLabelSettings,
																			plugin: {
																				...whiteLabelSettings.plugin,
																				description,
																			},
																		}
																	)
																}}
															/>
														</div>

														<div>
															<label>
																{__(
																	'Plugin Thumbnail URL',
																	'blc'
																)}
															</label>

															<div className="ct-upload-thumb">
																<input
																	type="text"
																	value={
																		whiteLabelSettings
																			.plugin
																			.thumbnail ||
																		''
																	}
																	onChange={({
																		target: {
																			value: thumbnail,
																		},
																	}) => {
																		setWhiteLabelSettings(
																			{
																				...whiteLabelSettings,
																				plugin: {
																					...whiteLabelSettings.plugin,
																					thumbnail,
																				},
																			}
																		)
																	}}
																/>

																<button
																	className="button"
																	onClick={() => {
																		let frame = wp.media(
																			{
																				button: {
																					text:
																						'Select',
																				},
																				states: [
																					new wp.media.controller.Library(
																						{
																							title:
																								'Select logo',
																							library: wp.media.query(
																								{
																									type:
																										'image',
																								}
																							),
																							multiple: false,
																							date: false,
																							priority: 20,
																						}
																					),
																				],
																			}
																		)

																		frame
																			.setState(
																				'library'
																			)
																			.open()

																		frame.on(
																			'select',
																			() => {
																				var attachment = frame
																					.state()
																					.get(
																						'selection'
																					)
																					.first()
																					.toJSON()

																				setWhiteLabelSettings(
																					{
																						...whiteLabelSettings,
																						plugin: {
																							...whiteLabelSettings.plugin,
																							thumbnail:
																								attachment.url,
																						},
																					}
																				)
																			}
																		)
																	}}>
																	{__(
																		'Choose File',
																		'blc'
																	)}
																</button>

																<span>
																	{__(
																		'You can insert the link to a self hosted image or upload one. The recommended image size is 256px wide by 256px tall.',
																		'blc'
																	)}
																</span>
															</div>
														</div>
													</Fragment>
												),
											},
										].map((section) => (
											<section
												className="ct-layer"
												key={section.key}>
												<div
													className="ct-layer-controls"
													onClick={() => {
														setOpenView(
															section.key ===
																openView
																? null
																: section.key
														)
													}}>
													<span>{section.title}</span>
													<button
														type="button"
														className="ct-toggle"
													/>
												</div>

												{section.key === openView && (
													<div className="ct-layer-content">
														<div className="ct-white-label-group">
															{section.content()}
														</div>
													</div>
												)}
											</section>
										))}

									{currentTab === 'advanced' && (
										<div className="ct-white-label-actions-group">
											{[
												{
													id: 'hide_billing_account',
													text: __(
														'Hide Account Menu Item',
														'blc'
													),
												},

												{
													id: 'hide_demos',
													text: __(
														'Hide Starter Sites Tab',
														'blc'
													),
												},
												{
													id: 'hide_plugins_tab',
													text: __(
														'Hide Useful Plugins Tab',
														'blc'
													),
												},

												{
													id: 'hide_changelogs_tab',
													text: __(
														'Hide Changelog Tab',
														'blc'
													),
												},

												{
													id: 'hide_support_section',
													text: __(
														'Hide Support Section',
														'blc'
													),
												},

												{
													id: 'hide_beta_updates',
													text: __(
														'Hide Beta Updates Section',
														'blc'
													),
												},
											].map(({ id, text }) => (
												<label
													onClick={() =>
														setWhiteLabelSettings({
															...whiteLabelSettings,
															[id]: !whiteLabelSettings[
																id
															],
														})
													}>
													{text}
													<Switch
														option={{
															behavior: 'boolean',
														}}
														value={
															whiteLabelSettings[
																id
															]
														}
														onChange={() => {}}
													/>
												</label>
											))}

											<label
												onClick={() =>
													setWhiteLabelSettings({
														...whiteLabelSettings,
														locked: !whiteLabelSettings.locked,
													})
												}>
												{__(
													'Hide White Label Extension',
													'blc'
												)}
												<Switch
													option={{
														behavior: 'boolean',
													}}
													value={
														whiteLabelSettings.locked
													}
													onChange={() => {}}
												/>
											</label>

											{whiteLabelSettings.locked && (
												<div className="extension-notice">
													{__(
														'Please note that the white label extension will be hidden if this option is enabled. In order to bring it back you have to hit the SHIFT key and click on the dashboard logo.',
														'blc'
													)}
												</div>
											)}
										</div>
									)}
								</div>
							</div>
						</div>

						<div className="ct-modal-actions has-divider">
							<button
								className="button-primary"
								onClick={(e) => {
									e.preventDefault()
									saveWhiteLabelSettings()

									ctEvents.trigger('blocksy_exts_sync_exts')
								}}>
								{__('Save Settings', 'blc')}
							</button>
						</div>
					</div>
				)}
			/>
		</Fragment>
	)
}

export default EditSettings

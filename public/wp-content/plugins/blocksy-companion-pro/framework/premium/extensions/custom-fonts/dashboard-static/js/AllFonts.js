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
import { humanizeVariations } from './helpers'

const AllFonts = ({
	customFontsSettings,
	onChange,
	moveToUploader,
	editFont,
}) => {
	return (
		<div className="ct-modal-content ct-all-fonts">
			<h2>{__('Custom Fonts Settings', 'blc')}</h2>
			<p>
				{__(
					'Here you can see all your custom fonts that could be used in all typography options across the theme.',
					'blc'
				)}
			</p>

			{customFontsSettings.fonts.length > 0 && (
				<div className="ct-modal-scroll">
					<ul>
						{customFontsSettings.fonts.map((font, index) => (
							<li key={index}>
								<span>
									{font.name}
									{font.__custom
										? ` (${__('Dynamic Font', 'blc')})`
										: ''}
									{font.fontType === 'variable' ? (
										<i>
											{__('Variable font', 'blc')}:&nbsp;
											{font.variations
												.filter(({ url }) => !!url)
												.map(({ variation }) =>
													humanizeVariations(
														variation,
														true
													)
												)
												.join(', ')}
										</i>
									) : (
										<i>
											{__('Variations', 'blc')}:&nbsp;
											{font.variations
												.map(({ variation }) =>
													humanizeVariations(
														variation
													)
												)
												.join(', ')}
										</i>
									)}
								</span>

								{!font.__custom && (
									<Fragment>
										<button
											className="ct-edit-font"
											onClick={() => editFont(index)}>
											<span className="ct-tooltip-top">
												{__('Edit Font', 'blc')}
											</span>
										</button>

										<button
											className="ct-remove-font"
											data-hover="red"
											onClick={() => {
												onChange({
													...customFontsSettings,
													fonts: customFontsSettings.fonts.filter(
														({ name }) =>
															name !== font.name
													),
												})
											}}>
											<span className="ct-tooltip-top">
												{__('Remove Font', 'blc')}
											</span>
										</button>
									</Fragment>
								)}
							</li>
						))}
					</ul>
				</div>
			)}

			{customFontsSettings.fonts.length === 0 && (
				<div className="ct-notification">
					{__(
						'There are no custom fonts at the moment, hit the button below and upload some.',
						'blc'
					)}
				</div>
			)}

			<div className="ct-modal-actions has-divider" data-buttons="2">
				<button
					className="button button-primary"
					onClick={() => {
						moveToUploader('regular')
					}}>
					{__('Upload Simple Font', 'blc')}
				</button>

				<button
					className="button button-primary"
					onClick={() => {
						moveToUploader('variable')
					}}>
					{__('Upload Variable Font', 'blc')}
				</button>
			</div>
		</div>
	)
}

export default AllFonts

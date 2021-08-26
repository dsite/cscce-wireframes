import {
	Fragment,
	createElement,
	createPortal,
	useState,
	useMemo,
} from '@wordpress/element'
import classnames from 'classnames'

import { __ } from 'ct-i18n'

const IconsList = ({
	searchString,
	filteredPacks,
	onChange,
	value,
	setSearchString,
}) => {
	return (
		<div className="ct-modal-tabs-content ct-predefined-icons-container">
			<div className="ct-option-input">
				<input
					type="text"
					placeholder={__('Search icon', 'blc')}
					value={searchString}
					onChange={({ target: { value } }) => setSearchString(value)}
				/>
			</div>

			<div className="ct-icons-list">
				{filteredPacks.map(({ name, icons, prefix }) => (
					<Fragment>
						<h2>{name}</h2>

						<ul>
							{icons
								.filter(
									({ icon }) =>
										icon.indexOf(searchString) > -1
								)
								.map(({ icon, svg }) => (
									<li
										key={icon}
										onClick={() => {
											onChange({
												...value,
												icon: `${prefix}${icon}`,
											})
										}}
										className={classnames({
											active:
												value.icon ===
												`${prefix}${icon}`,
										})}
										data-icon={`${prefix}${icon}`}
										dangerouslySetInnerHTML={{
											__html: svg,
										}}
									/>
								))}
						</ul>
					</Fragment>
				))}
			</div>
		</div>
	)
}

export default IconsList

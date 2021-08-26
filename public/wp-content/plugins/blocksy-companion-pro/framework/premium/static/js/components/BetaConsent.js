import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment,
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'
import { Switch, Overlay } from 'blocksy-options'

const BetaConsent = () => {
	const [hasConsent, setHasConsent] = useState(
		ctDashboardLocalizations.plugin_data.has_beta_consent
	)

	const [isLoading, setIsLoading] = useState(false)
	const [isShowingConfirm, setIsShowingConfirm] = useState(false)

	const toggleValue = async () => {
		if (isLoading) {
			return
		}

		setHasConsent((hasConsent) => !hasConsent)

		setIsLoading(true)

		const body = new FormData()

		body.append('action', 'blocksy_toggle_has_beta_consent')

		const response = await fetch(ctDashboardLocalizations.ajax_url, {
			method: 'POST',
			body,
		})

		window.ctDashboardLocalizations.plugin_data.has_beta_consent = !hasConsent

		setIsLoading(false)
	}

	return (
		<div className="ct-beta-consent">
			<h2
				onClick={() => {
					if (hasConsent) {
						toggleValue()
						return
					}

					setIsShowingConfirm(true)
				}}>
				{__('Receive βeta Updates', 'blc')}

				<Switch value={hasConsent ? 'yes' : 'no'} onChange={() => {}} />
			</h2>

			<p>
				{__(
					'Receive beta updates for Blocksy theme and companion and help us test the new versions. Please note that installing beta versions is not recommended on production sites.',
					'blc'
				)}
			</p>

			<Overlay
				items={isShowingConfirm}
				className="ct-admin-modal ct-beta-updates-consent"
				onDismiss={() => setIsShowingConfirm(false)}
				render={() => (
					<div className="ct-modal-content">
						<h2 className="ct-modal-title">
							{__('Are you sure?', 'blc')}
						</h2>
						<p>
							{__(
								'Installing beta updates on your production site can give unexpected results.',
								'blc'
							)}
						</p>

						<p>
							{__(
								'Even having your website completely broken is not excluded. Please proceed with caution.',
								'blc'
							)}
						</p>

						<div
							className="ct-modal-actions has-divider"
							data-buttons="2">
							<button
								onClick={(e) => {
									e.preventDefault()
									e.stopPropagation()
									setIsShowingConfirm(false)
								}}
								className="button">
								Cancel
							</button>

							<button
								className="button button-primary"
								onClick={(e) => {
									e.preventDefault()
									toggleValue()
									setIsShowingConfirm(false)
								}}>
								Confirm
							</button>
						</div>
					</div>
				)}
			/>
		</div>
	)
}

export default BetaConsent

<h2><?php echo __('Instructions', 'blc'); ?></h2>

<p>
	<?php echo __('After activating this extension you will be able to enable the read progress bar for your single posts, add a featured image and set different colors to each taxonomy, add custom fields to your archive cards or page/post title section with the help of ACF, MetaBox and Toolset plugins, and also add taxonomies archive filters.', 'blc') ?>
</p>

<ol class="ct-modal-list">
	<li>
		<h4><?php echo __('Custom Fields', 'blc') ?></h4>
		<i>
		<?php
			echo sprintf(
				__('After setting up your custom fields you will be able to output them from %s or from %2s.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Customizer ➝ Blog Posts ➝ Card Options', 'blc')
				),
				sprintf(
					'<code>%2s</code>',
					__('Customizer ➝ Single Posts ➝ Post Title', 'blc')
				)
			);
		?>
		</i>
	</li>

	<li>
		<h4><?php echo __('Taxonomies Filters', 'blc') ?></h4>
		<i>
		<?php
			echo sprintf(
				__('You can enable the taxonomies filters from %s.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Customizer ➝ Blog Posts ➝ Filters', 'blc')
				)
			);
		?>
		</i>
	</li>

	<li>
		<h4><?php echo __('Read Progress Bar', 'blc') ?></h4>
		<i>
		<?php
			echo sprintf(
				__('This options could be enabled from %s.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Customizer ➝ Single Posts ➝ Read Progress Bar', 'blc')
				)
			);
		?>
		</i>
	</li>

	<li>
		<h4><?php echo __('Taxonomy Featured Image & Custom Colors', 'blc') ?></h4>
		<i>
		<?php
			echo sprintf(
				__('To customize these options simply navigate to %s and edit one of your categories.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Dashboard ➝ Posts ➝ Categories', 'blc')
				)
			);
		?>
		</i>
	</li>
</ol>

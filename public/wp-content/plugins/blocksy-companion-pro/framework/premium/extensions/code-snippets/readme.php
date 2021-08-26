<h2><?php echo __('Instructions', 'blc'); ?></h2>

<p>
	<?php echo __('After activating the Custom Code Snippets extension you will have two ways to manage your snippets:', 'blc') ?>
</p>

<ol class="ct-modal-list">
	<li>
		<h4><?php echo __('Globally', 'blc') ?></h4>
		<i>
		<?php
			echo sprintf(
				__('Navigate to %s and place there your header, body or footer scripts.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Customizer ➝ Custom Code Snippets', 'blc')
				)
			);
		?>
		</i>
	</li>

	<li>
		<h4><?php echo __('Per page/post', 'blc') ?></h4>
		<i>
		<?php
			echo sprintf(
				__('Edit your page or post, click on %s, scroll down and you will see the %2s panel.', 'blc'),
				sprintf(
					'<code>%s</code>',
					sprintf(
						__('%s Page Settings', 'blc'),
						wp_get_theme()->get('Name')
					)
				),
				sprintf(
					'<code>%2s</code>',
					__('Custom Code Snippets', 'blc')
				)
			);
		?>
		</i>
	</li>
</ol>

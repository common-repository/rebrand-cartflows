<div class="flows-wl-settings-header">
	<h3><?php _e('Rebrand Cartflows', 'flows'); ?></h3>
</div>
<div class="flows-wl-settings-wlms">

	<div class="flows-wl-settings">
		<form method="post" id="form" enctype="multipart/form-data">

			<?php wp_nonce_field( 'flows_wl_nonce', 'flows_wl_nonce' ); ?>

			<div class="flows-wl-setting-tabs">
				<a href="#flows-wl-branding" class="flows-wl-tab active"><?php _e('Branding', 'bzflows'); ?></a>
				<a href="#flows-wl-branding-settings" class="flows-wl-tab"><?php _e('Settings', 'bzflows'); ?></a>
			</div>


			<div class="flows-wl-setting-tabs-content">

				<div id="flows-wl-branding" class="flows-wl-setting-tab-content active">
					<h3 class="flows-section-title"><?php esc_html_e('Branding', 'bzflows'); ?></h3>
					<p><?php esc_html_e('You can white label the plugin as per your requirement.', 'bzflows'); ?></p>
					<table class="form-table flows-wl-fields">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="flows_wl_plugin_name"><?php esc_html_e('Plugin Name', 'bzflows'); ?></label>
								</th>
								<td>
									<input id="flows_wl_plugin_name" name="flows_wl_plugin_name" type="text" class="regular-text" value="<?php if(isset($branding['plugin_name'])) { echo esc_attr($branding['plugin_name']); } ?>" placeholder="" />
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<label for="flows_wl_plugin_desc"><?php esc_html_e('Plugin Description', 'bzflows'); ?></label>
								</th>
								<td>
									<input id="flows_wl_plugin_desc" name="flows_wl_plugin_desc" type="text" class="regular-text" value="<?php if(isset($branding['plugin_desc'])) { echo esc_attr($branding['plugin_desc']); } ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="flows_wl_plugin_author"><?php esc_html_e('Developer / Agency', 'bzflows'); ?></label>
								</th>
								<td>
									<input id="flows_wl_plugin_author" name="flows_wl_plugin_author" type="text" class="regular-text" value="<?php if(isset($branding['plugin_author'])) { echo esc_attr($branding['plugin_author']); } ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="flows_wl_plugin_uri"><?php esc_html_e('Website URL', 'bzflows'); ?></label>
								</th>
								<td>
									<input id="flows_wl_plugin_uri" name="flows_wl_plugin_uri" type="text" class="regular-text" value="<?php if(isset($branding['plugin_uri'])) { echo esc_attr($branding['plugin_uri']); } ?>"/>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<label for="flows_wl_primary_color"><?php esc_html_e('Primary Color', 'bzflows'); ?></label>
								</th>
								<td>
									<input id="flows_wl_primary_color" name="flows_wl_primary_color" type="text" class="flows-wl-color-picker" value="" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
														
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="flows_menu_icon"><?php esc_html_e('Menu Icon', 'bzflows'); ?></label>
								</th>
								<td>
									<input class="regular-text" name="flows_menu_icon" id="flows_menu_icon" type="text" value="" disabled />
									<input class="button dashicons-picker" type="button" value="Choose Icon" data-target="#flows_menu_icon" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="flows_wl_logo"><?php esc_html_e('Logo', 'bzflows'); ?></label>
								</th>
								<td>
								<?php 
									$default_image = plugins_url('uploads/NoImage.png', __FILE__);

									if ( isset( $branding['cartflows_logo'] )  && $branding['cartflows_logo'] != '' ) {
										$image_attributes = wp_get_attachment_image_src( $branding['cartflows_logo'] );
										$src = $image_attributes[0];
										$value = $branding['cartflows_logo'];
									} else {
										$src = $default_image;
										$value = '';
									}
								?>
									<div class="flows upload">
										<img data-src="<?php echo esc_attr($default_image); ?>" src="<?php echo esc_attr($src); ?>" />
										<div class="btns">
											<input type="hidden" name="flows_wl_logo" id="flows_wl_logo" value="<?php echo esc_attr($value);?>" />
											<button type="button" class="flows_upload_image_button button" disabled><?php _e('Upload','bzflows'); ?></button>
											<button type="button" class="flows_remove_image_button button" disabled>&times;</button>
											<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
										</div>
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="flows_wl_small_logo"><?php esc_html_e('Small Logo', 'bzflows'); ?></label>
								</th>
								<td>
								<?php 
									$default_image = plugins_url('uploads/NoImage.png', __FILE__);

									if ( isset( $branding['cartflows_small_logo'] )  && $branding['cartflows_small_logo'] != '' ) {
										$image_attributes = wp_get_attachment_image_src( $branding['cartflows_small_logo'] );
										$src = $image_attributes[0];
										$value = $branding['cartflows_small_logo'];
									} else {
										$src = $default_image;
										$value = '';
									}
								?>
									<div class="flows upload">
										<img data-src="<?php echo esc_attr($default_image); ?>" src="<?php echo esc_attr($src); ?>" />
										<div class="btns">
											<input type="hidden" name="flows_wl_small_logo" id="flows_wl_small_logo" value="<?php echo esc_attr($value);?>" />
											<button type="button" class="flows_upload_image_button button" disabled><?php _e('Upload','bzflows'); ?></button>
											<button type="button" class="flows_remove_image_button button" disabled>&times;</button>
											<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
										</div>
									</div>
								</td>
							</tr>

							
						</tbody>
					</table>
				</div>
		
				<div id="flows-wl-branding-settings" class="flows-wl-setting-tab-content">
					
					<table class="form-table flows-wl-fields">
		
						<tr valign="top">
							<th scope="row" valign="top">   
								<label for="flows_wl_plugin_flow_name"><?php esc_html_e('Flows - Text', 'bzflows'); ?></label>
							</th>
							<td>
								<input id="flows_wl_plugin_flow_name" name="flows_wl_plugin_flow_name" type="text" class="regular-text" value="" placeholder="" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>
											
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="flows_wl_plugin_step_library_text"><?php esc_html_e('Steps - Text', 'bzflows'); ?></label>
							</th>
							<td>
								<input id="flows_wl_plugin_step_library_text" name="flows_wl_plugin_step_library_text" type="text" class="regular-text" value="" placeholder="" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>
								
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="flows_wl_hide_external_links"><?php echo esc_html_e('Hide Getting Started Video ', 'bzflows'); ?></label>
							</th>
							<td>
								<input id="flows_wl_hide_external_links" name="flows_wl_hide_external_links" type="checkbox" class="" value="on" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="flows_wl_remove_pro_word"><?php echo esc_html_e('Remove "Pro" from Templates', 'bzflows'); ?></label>
							</th>
							<td>
								<input id="flows_wl_remove_pro_word" name="flows_wl_remove_pro_word" type="checkbox" class="" value="on" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="flows_wl_remove_learn_how"><?php echo esc_html_e('Remove "Knowledge Base" & "Support" Link', 'bzflows'); ?></label>
							</th>
							<td>
								<input id="flows_wl_remove_learn_how" name="flows_wl_remove_learn_how" type="checkbox" class="" value="on" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>

					 </table>
				
				</div>
			
				<div class="flows-wl-setting-footer">
					<p class="submit">
						<input type="submit" name="flows_submit" id="flows_save_branding" class="button button-primary flows-save-button" value="<?php esc_html_e('Save Settings', 'bzflows'); ?>" />
					</p>
				</div>
				
			</div>
		</form>
	</div>
</div>

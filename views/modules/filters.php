<div class="row">
    <div class="col-sm-7">
        <form action="<?php echo esc_url( $this->form_data['form_action'] ) ?>" method="POST" id="<?php echo esc_attr( CONFIG['PLUGIN_ID'] ); ?>_filters_form">
            <input type="hidden" name="action" value="<?php echo esc_attr( CONFIG['PLUGIN_ID'] ); ?>_filters_form" />
            <input type="hidden" name="<?php echo esc_attr( CONFIG['PLUGIN_ID'] ); ?>_filters_form_nonce" value="<?php echo $this->form_data['filters']['nonce'] ?>" />	
            <h5>Cache Clearing</h5>
            <div class="block">
                <pre>
                    <code class="language-php line-numbers" data-prismjs-copy="Copy the snippet">
                        add_filter( 'rocket_post_purge_urls', function( $purge_urls ) {
                            $purge_urls = false;
                            return $purge_urls;
                        } );
                    </code>
                </pre>
            </div>


            <div class="mb-3 w-50">
                <label for="rocket_post_purge_urls" class="form-label"><code>rocket_post_purge_urls</code> filter to return:</label>
                <select class="form-select" name="rocket_post_purge_urls" id="rocket_post_purge_urls" aria-label="rocket_post_purge_urls filter value">
                    <option selected value="">Select a value to return</option>
                    <?php foreach ( $this->form_data['filters']['rocket_post_purge_urls']['form_data'] as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $this->form_data['filters']['rocket_post_purge_urls']['state'] ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h5>Exclude taxonomy from purge</h5>
            <div class="block">
                <pre>
                    <code class="language-php line-numbers" data-prismjs-copy="Copy the snippet">
                    add_filter( 'rocket_exclude_post_taxonomy', function ( $taxonomies ) {
                        $taxonomies[] = 'category';
                        return $taxonomies;
                    } );
                    </code>
                </pre>
            </div>

            <div class="mb-3 w-50">
                <label for="rocket_exclude_post_taxonomy" class="form-label"><code>rocket_exclude_post_taxonomy</code> filter to return:</label>
                <select class="form-select" name="rocket_exclude_post_taxonomy" id="rocket_exclude_post_taxonomy" aria-label="rocket_exclude_post_taxonomy filter value">
                    <option selected value="">Select a value to return</option>
                    <?php foreach ( $this->form_data['filters']['rocket_exclude_post_taxonomy']['form_data'] as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $this->form_data['filters']['rocket_exclude_post_taxonomy']['state'] ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h5>Rocket Insights</h5>
            <div class="block">
                <pre>
                    <code class="language-php line-numbers" data-prismjs-copy="Copy the snippet">
                    add_filter( 'rocket_rocket_insights_enabled', '__return_false' );
                    </code>
                </pre>
            </div>

            <div class="mb-3 w-50">
                <label for="rocket_rocket_insights_enabled" class="form-label"><code>rocket_rocket_insights_enabled</code> filter to return:</label>
                <select class="form-select" name="rocket_rocket_insights_enabled" id="rocket_rocket_insights_enabled" aria-label="rocket_rocket_insights_enabled filter value">
                    <option value="" <?php echo '' === $this->form_data['filters']['rocket_rocket_insights_enabled']['state'] ? 'selected="selected"' : '' ?>>Select a value to return</option>
                    <?php foreach ( $this->form_data['filters']['rocket_rocket_insights_enabled']['form_data'] as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $this->form_data['filters']['rocket_rocket_insights_enabled']['state'] ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h5>Active Promo Simulation</h5>
            <div class="block">
                <pre>
                    <code class="language-php line-numbers" data-prismjs-copy="Copy the snippet">
                    add_filter( 'transient_wp_rocket_pricing', function ( $value ) {
                        if ( empty( $value ) || ! is_object( $value ) ) {
                            return $value;
                        }
                        $value->promo = (object) [
                            'name'             => 'Test Summer Sale',
                            'discount_percent' => 30,
                            'start_date'       => strtotime( '-1 day' ),
                            'end_date'         => strtotime( '+5 days' ),
                        ];
                        return $value;
                    } );
                    </code>
                </pre>
            </div>

            <div class="mb-3 w-50">
                <label for="transient_wp_rocket_pricing" class="form-label">Apply <code>transient_wp_rocket_pricing</code> promo override:</label>
                <select class="form-select" name="transient_wp_rocket_pricing" id="transient_wp_rocket_pricing" aria-label="transient_wp_rocket_pricing filter state">
                    <?php foreach ( $this->form_data['filters']['transient_wp_rocket_pricing']['form_data'] as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $this->form_data['filters']['transient_wp_rocket_pricing']['state'] ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h5>License Type Override</h5>
            <div class="block">
                <pre>
                    <code class="language-php line-numbers" data-prismjs-copy="Copy the snippet">
                    // Select a value in the "License type" dropdown below.
                    // The selected type maps to credentials in config/license-credentials.php.
                    add_filter( 'pre_get_rocket_option_consumer_key', function ( $value ) {
                        return $value;
                    } );
                    add_filter( 'pre_get_rocket_option_consumer_email', function ( $value ) {
                        return $value;
                    } );
                    // Note: expiration and auto-renew are controlled by the
                    // "License expiration" and "Auto renew" dropdowns below.
                    </code>
                </pre>
            </div>

            <div class="mb-3 w-50">
                <label for="license_type_override" class="form-label">License type (overrides consumer key &amp; email):</label>
                <select class="form-select" name="license_type_override" id="license_type_override" aria-label="License type override">
                    <?php foreach ( $this->form_data['filters']['license_type_override']['form_data'] as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $this->form_data['filters']['license_type_override']['state'] ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="license_expiration_override" class="form-label">License expiration:</label>
                <select class="form-select" name="license_expiration_override" id="license_expiration_override" aria-label="License expiration override">
                    <?php foreach ( $this->form_data['filters']['license_expiration_override']['form_data'] as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $this->form_data['filters']['license_expiration_override']['state'] ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="license_auto_renew_override" class="form-label">Auto renew: if enabled, expiring soon and just expired banners will not be displayed</label>
                <select class="form-select" name="license_auto_renew_override" id="license_auto_renew_override" aria-label="License auto renew override">
                    <?php foreach ( $this->form_data['filters']['license_auto_renew_override']['form_data'] as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $this->form_data['filters']['license_auto_renew_override']['state'] ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

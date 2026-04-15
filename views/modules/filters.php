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
                        if ( empty( $value ) ) {
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

            <h5>License Simulation</h5>
            <div class="block">
                <pre>
                    <code class="language-php line-numbers" data-prismjs-copy="Copy the snippet">
                    add_filter( 'transient_wp_rocket_customer_data', function ( $value ) {
                        if ( empty( $value ) ) {
                            return $value;
                        }
                        $value->licence->name = '';
                        $value->licence_account = '3';
                        $value->licence_expiration = strtotime( '+5 days' );
                        $value->has_auto_renew = false;
                        return $value;
                    } );
                    </code>
                </pre>
            </div>


            <?php
            $license_simulation_options = $this->form_data['filters']['transient_wp_rocket_customer_data_license_simulation']['form_data'] ?? [
                'disabled' => 'disabled',
                'enabled' => 'enabled',
            ];
            $license_simulation_state = $this->form_data['filters']['transient_wp_rocket_customer_data_license_simulation']['state'] ?? 'disabled';


            $license_type_options = $this->form_data['filters']['transient_wp_rocket_customer_data_license_type']['form_data'] ?? [
                'default' => 'keep existing',
                '1' => '1 - single',
                '3' => '3 - plus',
                '50' => '50 - multi50',
                '100' => '100 - multi100',
                '500' => '500 - multi500',
                '-1' => '-1 - infinite',
            ];
            $license_type_state = $this->form_data['filters']['transient_wp_rocket_customer_data_license_type']['state'] ?? 'default';

            $license_expiration_options = $this->form_data['filters']['transient_wp_rocket_customer_data_license_expiration']['form_data'] ?? [
                'default' => 'keep existing',
                'not_expired' => 'not expired (+1 year)',
                'expiring_soon' => 'expiring soon (+5 days)',
                'expired' => 'expired (-1 month)',
            ];
            $license_expiration_state = $this->form_data['filters']['transient_wp_rocket_customer_data_license_expiration']['state'] ?? 'default';

            $auto_renewal_options = $this->form_data['filters']['transient_wp_rocket_customer_data_auto_renewal']['form_data'] ?? [
                'default' => 'keep existing',
                'enabled' => 'enabled',
                'disabled' => 'disabled',
            ];
            $auto_renewal_state = $this->form_data['filters']['transient_wp_rocket_customer_data_auto_renewal']['state'] ?? 'default';
            ?>

            <div class="mb-3 w-50">
                <label for="transient_wp_rocket_customer_data_license_simulation" class="form-label">Apply <code>transient_wp_rocket_customer_data</code> license override:</label>
                <select class="form-select" name="transient_wp_rocket_customer_data_license_simulation" id="transient_wp_rocket_customer_data_license_simulation" aria-label="transient_wp_rocket_customer_data license override state">
                    <?php foreach ( $license_simulation_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $license_simulation_state ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="transient_wp_rocket_customer_data_license_type" class="form-label">License type:</label>
                <select class="form-select" name="transient_wp_rocket_customer_data_license_type" id="transient_wp_rocket_customer_data_license_type" aria-label="License type">
                    <?php foreach ( $license_type_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo (string) $key === (string) $license_type_state ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            
            <div class="mb-3 w-50">
                <label for="transient_wp_rocket_customer_data_license_expiration" class="form-label">Expiration state:</label>
                <select class="form-select" name="transient_wp_rocket_customer_data_license_expiration" id="transient_wp_rocket_customer_data_license_expiration" aria-label="License expiration state">
                    <?php foreach ( $license_expiration_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $license_expiration_state ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="transient_wp_rocket_customer_data_auto_renewal" class="form-label">Auto renewal state:</label>
                <select class="form-select" name="transient_wp_rocket_customer_data_auto_renewal" id="transient_wp_rocket_customer_data_auto_renewal" aria-label="Auto renewal state">
                    <?php foreach ( $auto_renewal_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $auto_renewal_state ? 'selected="selected"' : '' ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

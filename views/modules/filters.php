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

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<?php
defined( 'ABSPATH' ) || exit;
?>

<h5>Tools</h5>
<div class="row">
    <div class="col-md-3">
        <a href="<?php echo admin_url( 'tools.php?page='. $plugin_id . '&wpr_e2e_action=save_last_major_version&wp_nonce=' . $wp_nonce ) ?>" class="btn btn-primary">Save last major version</a>
    </div>
</div>

<div class="row">
  <?php foreach ( $this->modules['tools']['test_cases'] as $test_case_id => $test_case ) : ?>
    <div class="col-sm-4 mb-3 mb-sm-0">
    <div class="card px-2 border-0 shadow">
      <div class="card-body">
        <div class="card-subtitle-box">
          <h6 class="card-subtitle mb-2"><?php echo esc_html( $test_case['name'] ); ?></h6>
          <?php if ( ! empty( $test_case['note'] ) ) : ?>
                  <p class="font-sm text-<?php echo esc_attr( $test_case['note']['type'] ); ?>">
                    <strong><?php echo esc_html( $test_case['note']['text'] );  ?></strong>
                  </p>
          <?php endif; ?>
        </div>
        <small class="d-inline-flex px-2 py-1 fw-semibold text-success-emphasis bg-primary-subtle border border-primary-subtle rounded-2" id="<?php echo esc_attr( $test_case_id ) ?>">
            <?php echo $test_case['result'] ? 'Returned True' : 'Returned False';  ?>
        </small>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
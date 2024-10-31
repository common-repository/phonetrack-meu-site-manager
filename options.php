<div class="wrap">
  <h2>PhoneTrack Meu Site Manager</h2>

  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <?php settings_fields('phtmanager'); ?>
    <table class="form-table">
      <tbody>
        <tr valign="top">
          <th scope="row"><?php _e('Hash da integração do Meu Site', 'phonetrack-meu-site-manager') ?>:</th>
          <td>
            <input type="text" name="pht_id" style="width: 50%" value="<?php echo isValidMd5(get_option('pht_id'))? get_option('pht_id') : 'invalid-entry'; ?>" />
            <p class="description" id="new-admin-email-description">
              <a target="_blank" href="https://phonetrack.app/account/integracao/script?tab=tab-script"><?php _e('Clique aqui para conseguir o Hash da integração do Meu Site.', 'phonetrack-meu-site-manager') ?></a></p>
          </td>
          </tr>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="action" value="update" />
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
  </form>
</div>

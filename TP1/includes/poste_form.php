<?php
if (!function_exists('render_post_form')) {
    function render_post_form(array $values, array $errors = []): void
    {
        $escape = static function (?string $text): string {
            return htmlspecialchars((string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        };
        $value = static function (string $key) use ($values, $escape): string {
            return $escape($values[$key] ?? '');
        };
        $error = static function (string $key) use ($errors, $escape): string {
            return isset($errors[$key]) ? $escape($errors[$key]) : '';
        };
        ?>
        <form method="post" action="pentest.php" novalidate>
          <div class="row">
            <div class="col">
              <label for="hostname">Hostname <span class="muted">(3-30 caracteres)</span></label>
              <?php if ($error('hostname')): ?>
                <p class="error"><?= $error('hostname'); ?></p>
              <?php endif; ?>
              <input type="text" name="hostname" id="hostname" required minlength="3" maxlength="30" pattern="[A-Za-z0-9_-]{3,30}" value="<?= $value('hostname'); ?>">
            </div>
            <div class="col">
              <label for="ip">Adresse IPv4</label>
              <?php if ($error('ip')): ?>
                <p class="error"><?= $error('ip'); ?></p>
              <?php endif; ?>
              <input type="text" name="ip" id="ip" required inputmode="decimal" placeholder="192.168.1.10" value="<?= $value('ip'); ?>">
            </div>
          </div>

          <div class="row">
            <div class="col">
              <label for="cidr">Masque (CIDR)</label>
              <?php if ($error('cidr')): ?>
                <p class="error"><?= $error('cidr'); ?></p>
              <?php endif; ?>
              <input type="number" name="cidr" id="cidr" required min="8" max="30" value="<?= $value('cidr'); ?>">
            </div>
            <div class="col">
              <label for="gateway">Passerelle</label>
              <?php if ($error('gateway')): ?>
                <p class="error"><?= $error('gateway'); ?></p>
              <?php endif; ?>
              <input type="text" name="gateway" id="gateway" required placeholder="192.168.1.1" value="<?= $value('gateway'); ?>">
            </div>
          </div>

          <div class="row">
            <div class="col">
              <label for="vlan">VLAN (1-4094)</label>
              <?php if ($error('vlan')): ?>
                <p class="error"><?= $error('vlan'); ?></p>
              <?php endif; ?>
              <input type="number" name="vlan" id="vlan" required min="1" max="4094" value="<?= $value('vlan'); ?>">
            </div>
            <div class="col">
              <label for="port">Port (Gi1/0/12, Fa0/3, ...)</label>
              <?php if ($error('port')): ?>
                <p class="error"><?= $error('port'); ?></p>
              <?php endif; ?>
              <input type="text" name="port" id="port" required maxlength="20" placeholder="Gi1/0/12" value="<?= $value('port'); ?>">
            </div>
          </div>

          <?php if ($error('global')): ?>
            <p class="error"><?= $error('global'); ?></p>
          <?php endif; ?>

          <button class="btn" type="submit">Saisir rapport pentest</button>
          <a class="btn secondary" href="index.php">Retour menu</a>
        </form>
        <?php
    }
}

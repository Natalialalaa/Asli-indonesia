<?php
/* Template Name: Restaurant Page */
get_header(); ?>

<!-- Decorative Flower Right -->
<div class="deco-1">
  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/bungabatik1.png'); ?>" alt="Decoration Flower 1" class="deco-flower-1-right">
</div>

<section id="restaurant">
  <div class="section-container">
    <div class="section-text">
      <h2 class="section-title">
        <?php echo esc_html( get_field('restaurant_title') ?: 'Le Restaurant' ); ?>
      </h2>

      <p class="section-description">
        <?php
        $desc = get_field('restaurant_description');
        echo $desc ? wp_kses_post($desc) : "Débuté en 2021 au Marché des Capucins, nous sommes maintenant prêts à vous faire savourer nos délicieux plats chaque jour dans notre nouveau restaurant, en plein cœur de Bordeaux, ouvert depuis avril 2025";
        ?>
      </p>
    </div>
    <div class="line-break"></div>
  </div>

  <div class="restaurant-gallery">
    <div class="scroll-content">
      <?php
      // Up to 3 gallery images (Free ACF: three Image fields)
      $gallery = [
        get_field('restaurant_image_1'),
        get_field('restaurant_image_2'),
        get_field('restaurant_image_3'),
      ];
      foreach ($gallery as $img) {
        if (!$img) continue;
        $url = esc_url($img['url']);
        $alt = esc_attr($img['alt'] ?: 'Restaurant image');
        echo "<img src=\"$url\" alt=\"$alt\">";
      }
      // Duplicate for seamless loop
      foreach ($gallery as $img) {
        if (!$img) continue;
        $url = esc_url($img['url']);
        $alt = esc_attr(($img['alt'] ?: 'Restaurant image') . ' duplicate');
        echo "<img src=\"$url\" alt=\"$alt\">";
      }
      ?>
    </div>
  </div>
</section>

<section class="team-section">
  <div class="section-container">
    <div class="section-text">
      <h3 class="section-title">
        <?php echo esc_html( get_field('team_title') ?: "l'équipe" ); ?>
      </h3>
      <p class="section-description">
        <?php
        $team_desc = get_field('team_description');
        echo $team_desc ? wp_kses_post($team_desc) : 'Une équipe de service et cuisiniers pour vous régaler !';
        ?>
      </p>
    </div>
  </div>

  <div class="team-members-container">
    <div class="team-members">
      <?php
      // Exactly 3 members (Free ACF: no repeater)
      $members = [
        ['photo'=>'team1_photo','name'=>'team1_name','role'=>'team1_role'],
        ['photo'=>'team2_photo','name'=>'team2_name','role'=>'team2_role'],
        ['photo'=>'team3_photo','name'=>'team3_name','role'=>'team3_role'],
      ];
      $fallbacks = [
        ['n'=>'Aya N','r'=>'Chef de cuisine','img'=> get_template_directory_uri() . '/assets/src/profil.png'],
        ['n'=>'Budi G','r'=>'Serveur','img'=> get_template_directory_uri() . '/assets/src/profil2.png'],
        ['n'=>'Amelia R','r'=>'Serveuse','img'=> get_template_directory_uri() . '/assets/src/profil3.png'],
      ];
      foreach ($members as $i => $m):
        $p = get_field($m['photo']);
        $n = get_field($m['name']) ?: $fallbacks[$i]['n'];
        $r = get_field($m['role']) ?: $fallbacks[$i]['r'];
        $img_url = $p ? esc_url($p['url']) : esc_url($fallbacks[$i]['img']);
        $img_alt = $p ? esc_attr($p['alt'] ?: 'Team member') : 'Team member';
      ?>
        <div class="team-member">
          <img src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>">
          <p class="team-member-name"><?php echo esc_html($n); ?></p>
          <p class="team-member-role"><?php echo esc_html($r); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="restaurant-info">
  <div class="section-container">
    <div class="section-text">
      <h3 class="section-title">
        <?php echo esc_html( get_field('hours_title') ?: "L'horaire" ); ?>
      </h3>
      <p class="section-description">
		<?php
		// Note shown near the title/intro
		$hours_note_1 = get_field('hours_note-1');
		echo $hours_note_1
		  ? wp_kses_post($hours_note_1)
		  : "Veuillez nous contacter pour plus d'informations sur nos horaires.";
		?>
      </p>
    </div>
  </div>

  <div class="info-hours-container">
    <ul class="info-hours">
      <?php
      $days = [
        'Lundi'     => ['mon_lunch','mon_dinner'],
        'Mardi'     => ['tue_lunch','tue_dinner'],
        'Mercredi'  => ['wed_lunch','wed_dinner'],
        'Jeudi'     => ['thu_lunch','thu_dinner'],
        'Vendredi'  => ['fri_lunch','fri_dinner'],
        'Samedi'    => ['sat_lunch','sat_dinner'],
        'Dimanche'  => ['sun_lunch','sun_dinner'],
      ];
      $defaults = [
        'Lundi' => ['11h00 - 14h30','Fermé'],
        'Mardi' => ['11h00 - 14h30','Fermé'],
        'Mercredi' => ['11h00 - 14h30','18h00 - 22h00'],
        'Jeudi' => ['11h00 - 14h30','18h00 - 22h00'],
        'Vendredi' => ['11h00 - 14h30','18h00 - 22h00'],
        'Samedi' => ['11h00 - 14h30','18h00 - 22h30'],
        'Dimanche' => ['Fermé',''],
      ];
      foreach ($days as $label => $pair):
        $lunch  = trim((string) get_field($pair[0]));
        $dinner = trim((string) get_field($pair[1]));
        if ($lunch === '' && $dinner === '') {
          $lunch  = $defaults[$label][0];
          $dinner = $defaults[$label][1];
        }
      ?>
        <li>
          <span class="day"><?php echo esc_html($label); ?></span>
          <span class="hours">
            <?php if ($lunch !== ''): ?><p><?php echo esc_html($lunch); ?></p><?php endif; ?>
            <?php if ($dinner !== ''): ?><p><?php echo esc_html($dinner); ?></p><?php endif; ?>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="note-horaire">
		<?php
		// Note shown under the hours list
		echo wp_kses_post(
		  get_field('hours_note-2')
		  ?: "*Les horaires peuvent être modifiés en cas de fête spéciale ou de jour férié. Vous pouvez consulter notre actualité sur les réseaux sociaux ou nous contacter en cas de doute."
		);
		?>
    </p>
  </div>
</section>

<!-- Decorative Flower Left -->
<div class="deco-1">
  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/bungabatik1.png'); ?>" alt="Decoration Flower 1" class="deco-flower-1-left">
</div>

<section id="location" class="location-section">
  <div class="line-break"></div>
  <div class="section-container">
    <div class="section-text">
      <h3 class="section-title">
        <?php echo esc_html( get_field('location_title') ?: 'Où nous trouver' ); ?>
      </h3>
      <?php
      $addr = get_field('location_address');
      if ($addr): ?>
        <p class="section-description"><?php echo nl2br( esc_html($addr) ); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="map-container">
    <div class="google-map">
      <?php
      $iframe = get_field('location_map_iframe');
      if ($iframe) {
        echo wp_kses($iframe, [
          'iframe' => [
            'src'=>[], 'width'=>[], 'height'=>[], 'style'=>[], 'allowfullscreen'=>[],
            'loading'=>[], 'referrerpolicy'=>[]
          ]
        ]);
      } else {
        // Fallback to your original embed
        ?>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2829.3489459935613!2d-0.5793809038767012!3d44.83482660062405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd552700478a5e45%3A0x97974535a2b18945!2sAsli%20Cuisine%20Indon%C3%A9sienne!5e0!3m2!1sen!2sfr!4v1754413670038!5m2!1sen!2sfr"
          width="600" height="450" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <?php
      }
      ?>
    </div>

    <div class="location-details">
      <div class="location-transport">
        <ul>
          <?php
          for ($i=1; $i<=3; $i++):
            $icon = get_field("transport{$i}_icon");
            $text = get_field("transport{$i}_text");
            if (!$icon && !$text) continue;
          ?>
            <li>
              <?php if ($icon): ?>
                <img src="<?php echo esc_url($icon['url']); ?>" alt="Transport <?php echo $i; ?>">
              <?php endif; ?>
              <?php if ($text): ?>
                <p><?php echo wp_kses_post($text); ?></p>
              <?php endif; ?>
            </li>
          <?php endfor; ?>
        </ul>
      </div>

      <?php
      $btn_text = get_field('location_button_text') ?: "J'y vais !";
      $btn_url  = get_field('location_button_url') ?: 'https://www.google.com/maps/dir/?api=1&destination=Asli+Indonesia+Restaurant,+158+Cr+Victor+Hugo,+Bordeaux,+France';
      ?>
      <button class="cta-button" onclick="window.location.href='<?php echo esc_url($btn_url); ?>'">
        <?php echo esc_html($btn_text); ?>
      </button>
    </div>
  </div>
</section>

<?php get_footer(); ?>

<?php
$entreprise = [
  'name' => 'KATCHAM COMPANY',
  'tagline' => 'Transport - Bâtiments & Travaux Publics',
  'description' => "KATCHAM COMPANY est spécialisée dans le transport et les Bâtiments & Travaux Publics (BTP), offrant des solutions fiables et innovantes pour la mobilité et la construction. Notre expertise nous permet de réaliser vos projets avec professionnalisme, sécurité et efficacité. Construisons l'avenir ensemble !",
  // Variantes en anglais (modifiables)
  'name_en' => 'KATCHAM COMPANY',
  'tagline_en' => 'Transport - Construction & Public Works',
  'description_en' => "KATCHAM COMPANY is specialized in transport and construction and public works (BTP), offering reliable and innovative solutions for mobility and construction. Our expertise allows us to realize your projects with professionalism, safety and efficiency. Let's build the future together!",
  'address' => 'BP 1352 Yamoussoukro, Quartier Sopim',
  'address_en' => 'BP 1352 Yamoussoukro, Quartier Sopim',
  'city' => 'Yamoussoukro',
  'city_en' => 'Yamoussoukro',
  'postal_code' => '', 
  'country' => 'Côte d\'Ivoire',
  'country_en' => "Côte d’Ivoire (Ivory Coast)",
  'phone' => '+225 01 00 10 10 71',
  'phone2' => '+225 07 07 07 50 19',
  'email' => 'katchamcompany@gmail.com',
  'ncc' => 'N°CC: 2218960',
  'boa' => 'BOA N°: CI032 04001 005955310005 69',
  'website' => '',
  'logo_url' => '../img/katcham_company_logo.png', // Ex: '/assets/logo.png' (optionnel)
  'qr_logo_url' => '', // Ex: '/assets/logo-qr.png' 
  'primary_color' => '#00285A', // Bleu
  'accent_color' => '#00285A',  // Cyan
  'text_color' => '#1f2937'     // Slate-900
];

// ------------------------------
// Langue et traductions
// ------------------------------
$lang = (isset($_GET['lang']) && $_GET['lang'] === 'en') ? 'en' : 'fr';
$traductions = [
  'fr' => [
    'translate' => 'Traduire',
    'print' => 'Imprimer',
    'download_png' => 'Télécharger le QR (PNG)',
    'copy_link' => 'Copier le lien',
    'link_copied' => 'Lien copié ✔',
    'about' => 'À propos',
    'website' => 'Site :',
    'email' => 'Email :',
    'phone' => 'Téléphone :',
    'phone2' => 'Contact :',
    'ncc' => 'N° CC :',
    'boa' => 'BOA :',
    'address' => 'Adresse :',
    'scan_footer' => 'Scannez le QR sur nos cartes pour revenir sur cette page et nous contacter rapidement.'
  ],
  'en' => [
    'translate' => 'Translate',
    'print' => 'Print',
    'download_png' => 'Download QR (PNG)',
    'copy_link' => 'Copy link',
    'link_copied' => 'Link copied ✔',
    'about' => 'About',
    'website' => 'Website:',
    'email' => 'Email:',
    'phone' => 'Phone:',
    'phone2' => 'Contact:',
    'ncc' => 'Tax ID:',
    'boa' => 'Bank Account (BOA):',
    'address' => 'Address:',
    'scan_footer' => 'Scan the QR on our cards to return to this page and contact us quickly.'
  ]
];

// ------------------------------
// Helpers
// ------------------------------
function construire_url_script_courant(): string {
  $https_actif = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);
  $schema = $https_actif ? 'https' : 'http';
  $hote = $_SERVER['HTTP_HOST'] ?? 'sama.ci';
  $chemin_script = $_SERVER['PHP_SELF'] ?? '/_php/vcard_e.php';
  return $schema . '://' . $hote . $chemin_script;
}

function generer_slug(string $texte): string {
  $texte = iconv('UTF-8', 'ASCII//TRANSLIT', $texte);
  $texte = preg_replace('~[^\\pL\\d]+~u', '-', $texte);
  $texte = trim($texte, '-');
  $texte = strtolower($texte);
  $texte = preg_replace('~[^-a-z0-9]+~', '', $texte);
  return $texte ?: 'sama-transport-trading sarl-btp-mining-sa';
}

// ------------------------------
// URL d’atterrissage encodée dans le QR
// ------------------------------
$url_destination = construire_url_script_courant();
// Ajouter une trace source basique pour les cartes
$separateur_requete = (parse_url($url_destination, PHP_URL_QUERY) ? '&' : '?');
$url_destination_avec_source = $url_destination . $separateur_requete . http_build_query(['src' => 'carte', 'lang' => $lang]);

$entreprise_slug = generer_slug($entreprise['name']);
$url_logo_qr = !empty($entreprise['qr_logo_url'] ?? '') ? $entreprise['qr_logo_url'] : (!empty($entreprise['qr_logo_url']) ? $entreprise['qr_logo_url'] : '');
?>
<!doctype html>
<html lang="<?php echo $lang; ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
      $nom_affiche = ($lang === 'en' && !empty($entreprise['name_en'])) ? $entreprise['name_en'] : $entreprise['name'];
      $slogan_affiche = ($lang === 'en' && !empty($entreprise['tagline_en'])) ? $entreprise['tagline_en'] : $entreprise['tagline'];
      $description_affiche = ($lang === 'en' && !empty($entreprise['description_en'])) ? $entreprise['description_en'] : $entreprise['description'];
      $adresse_affiche = ($lang === 'en' && !empty($entreprise['address_en'])) ? $entreprise['address_en'] : $entreprise['address'];
      $ville_affiche = ($lang === 'en' && !empty($entreprise['city_en'])) ? $entreprise['city_en'] : $entreprise['city'];
      $pays_affiche = ($lang === 'en' && !empty($entreprise['country_en'])) ? $entreprise['country_en'] : $entreprise['country'];
      $titre_suffix = ($lang === 'en') ? 'Card & QR' : 'Carte & QR';
    ?>
    <title><?php echo htmlspecialchars($nom_affiche . ' — ' . $titre_suffix); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($description_affiche); ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($nom_affiche . ' — ' . $slogan_affiche); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description_affiche); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($url_destination); ?>">
    <meta name="theme-color" content="<?php echo htmlspecialchars($entreprise['primary_color']); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
      :root { 
        --c-primary: <?php echo htmlspecialchars($entreprise['primary_color']); ?>;
        --c-accent: <?php echo htmlspecialchars($entreprise['accent_color']); ?>;
        --c-text: <?php echo htmlspecialchars($entreprise['text_color']); ?>;
        --c-muted: #475569;
        --c-border: #e2e8f0;
        --c-bg: #f8fafc;
        --radius: 16px;
      }
      * { box-sizing: border-box; }
      html, body { margin: 0; padding: 0; }
      body {
        font-family: 'Rubik', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
        color: var(--c-text);
        background: linear-gradient(180deg, #ffffff 0%, var(--c-bg) 100%);
      }
      /* Média fluides et prévention des débordements */
      img, video { max-width: 100%; height: auto; }
      .brand, .info-panel, .qr-panel { min-width: 0; }
      .list a { overflow-wrap: anywhere; word-break: break-word; }
      img, video { max-width: 100%; height: auto; }
      h1, h2, h3 { font-family: 'Poppins', 'Rubik', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif; }
      .wrap {
        max-width: 1100px;
        margin: 48px auto;
        padding: 0 20px;
      }
      header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
      }
      .logo {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 800;
        letter-spacing: 0.5px;
      }
      .brand h1 {
        margin: 0;
        font-size: 28px;
        line-height: 1.2;
      }
      .brand p {
        margin: 4px 0 0;
        color: var(--c-muted);
      }
      .lang-switch { margin-left: auto; display: flex; align-items: center; gap: 8px; }
      .lang-switch label { color: var(--c-muted); font-size: 14px; }
      .lang-select { border: 1px solid var(--c-border); border-radius: 10px; padding: 8px 10px; background: #fff; font-weight: 600; cursor: pointer; }
      .card {
        display: grid;
        grid-template-columns: minmax(0,1fr) minmax(0,1fr);
        gap: 28px;
        background: #fff;
        border: 1px solid var(--c-border);
        border-radius: var(--radius);
        padding: 28px;
        box-shadow: 0 10px 30px rgba(2, 8, 23, 0.06);
      }
      .qr-panel, .info-panel {
        background:rgb(255, 255, 255);
      }
      .qr-box {
        border: 1px dashed var(--c-border);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fafafa;
        width: 100%;
        max-width: 520px;
        margin: 0 auto;
      }
      #qrcode img, #qrcode canvas {
        width: 100%;
        height: auto;
        image-rendering: pixelated;
      }
      #qrcode { position: relative; display: inline-block; }
      #qrcode .qr-logo {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 36%;
        height: auto;
        max-height: 28%;
        border-radius: 12px;
        background: #ffffff;
        padding: 6px;
        box-shadow: 0 0 0 2px #ffffff;
        object-fit: contain;
        pointer-events: none;
      }
      .actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 14px;
      }
      .btn {
        appearance: none;
        border: 1px solid var(--c-border);
        background: #fff;
        color: var(--c-text);
        padding: 10px 14px;
        border-radius: 10px;
        font-family: 'Poppins', 'Rubik', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
        font-weight: 600;
        cursor: pointer;
        transition: all .15s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }
      .actions .btn { flex: 1 1 160px; }
      .btn.primary {
        border-color: transparent;
        background: linear-gradient(180deg, var(--c-accent), var(--c-primary));
        color: #fff;
      }
      .btn:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(2, 8, 23, 0.08); }
      .btn:active { transform: translateY(0); box-shadow: none; }
      .info-panel h2 {
        margin: 0 0 8px 0;
        font-size: 22px;
      }
      .muted { color: var(--c-muted); }
      .list {
        margin: 14px 0 0 0;
        padding: 0;
        list-style: none;
      }
      .list li {
        margin: 8px 0;
      }
      footer {
        margin-top: 18px;
        color: var(--c-muted);
        font-size: 13px;
      }
      @media (max-width: 860px) {
        .card { grid-template-columns: 1fr; }
        .logo { width: 100px; height: 150px; }
      }
      @media (max-width: 1024px) {
        .wrap { margin: 32px auto; padding: 0 16px; }
        .card { gap: 20px; padding: 22px; }
        .brand h1 { font-size: clamp(22px, 3.2vw, 26px); }
        .brand p { font-size: 14px; }
      }
      @media (max-width: 640px) {
        header { justify-content: center; text-align: center; gap: 12px; }
        .brand h1 { font-size: clamp(20px, 5.5vw, 24px); }
        .brand p { font-size: 13px; }
        .lang-switch { width: 100%; justify-content: center; margin-top: 8px; }
        .actions { gap: 8px; }
        .actions .btn { flex: 1 1 100%; justify-content: center; }
        .list .btn { display: block; width: 100%; text-align: center; }
        /* Forcer le logo d’en-tête à se réduire sur mobile malgré le style inline */
        header img.logo { height: 150px !important; width: auto !important; max-width: 90vw; }
      }
      @media (max-width: 400px) {
        .card { padding: 18px; }
        .btn { padding: 9px 12px; }
      }
      @media print {
        body { background: #fff; }
        .wrap { margin: 0; padding: 0; }
        header, .actions, footer { display: none !important; }
        .card { box-shadow: none; border: none; padding: 0; }
        .qr-box { border: none; padding: 0; }
        #qrcode img, #qrcode canvas { width: 80mm; height: 80mm; }
      }
    </style>
  </head>
  <body>
    <div class="wrap">
      <header>
        <?php if (!empty($entreprise['logo_url'])): ?>
          <img class="logo" style="width: 120px; height: 110px; background-color: #ffffff;" src="<?php echo htmlspecialchars($entreprise['logo_url']); ?>" alt="Logo <?php echo htmlspecialchars($nom_affiche); ?>" onerror="this.replaceWith(document.querySelector('.logo-fallback').cloneNode(true))">
          <div class="logo logo-fallback" style="display:none"><?php echo strtoupper(substr($nom_affiche, 0, 2)); ?></div>
        <?php else: ?>
          <div class="logo"><?php echo strtoupper(substr($nom_affiche, 0, 2)); ?></div>
        <?php endif; ?>
        <div class="brand">
          <h1><?php echo htmlspecialchars($nom_affiche); ?></h1>
          <p><?php echo htmlspecialchars($slogan_affiche); ?></p>
        </div>
        <div class="lang-switch">
          <label for="select_lang"><?php echo htmlspecialchars($traductions[$lang]['translate']); ?>:</label>
          <select id="select_lang" class="lang-select" aria-label="<?php echo htmlspecialchars($traductions[$lang]['translate']); ?>">
            <option value="fr" <?php if ($lang === 'fr') echo 'selected'; ?>>FR</option>
            <option value="en" <?php if ($lang === 'en') echo 'selected'; ?>>EN</option>
          </select>
        </div>
      </header>

      <div class="card">
        <section class="qr-panel">
          <div class="qr-box">
            <div id="qrcode" data-url="<?php echo htmlspecialchars($url_destination_avec_source); ?>"></div>
          </div>
          <div class="actions">
            <button class="btn primary" onclick="window.print()"><?php echo htmlspecialchars($traductions[$lang]['print']); ?></button>
            <button class="btn" id="btnDownloadQr"><?php echo htmlspecialchars($traductions[$lang]['download_png']); ?></button>
            <button class="btn" id="btnCopyLink"><?php echo htmlspecialchars($traductions[$lang]['copy_link']); ?></button>
          </div>
        </section>

        <section class="info-panel">
          <h2><?php echo htmlspecialchars($traductions[$lang]['about']); ?></h2>
          <p class="muted"><?php echo htmlspecialchars($description_affiche); ?></p>
          <ul class="list">
            <?php if (!empty($entreprise['website'])): ?>
              <li><strong><?php echo htmlspecialchars($traductions[$lang]['website']); ?></strong> <a href="<?php echo htmlspecialchars($entreprise['website']); ?>" class="btn btn-primary" target="_blank" rel="noopener"><?php echo htmlspecialchars($entreprise['website']); ?></a></li>
            <?php endif; ?>
            <?php if (!empty($entreprise['email'])): ?>
              <li><strong><?php echo htmlspecialchars($traductions[$lang]['email']); ?></strong> <a href="mailto:<?php echo htmlspecialchars($entreprise['email']); ?>" class="btn btn-primary"><?php echo htmlspecialchars($entreprise['email']); ?></a></li>
            <?php endif; ?>
            <?php if (!empty($entreprise['phone'])): ?>
              <li><strong><?php echo htmlspecialchars($traductions[$lang]['phone']); ?></strong> <a href="tel:<?php echo htmlspecialchars(preg_replace('/\\s+/', '', $entreprise['phone'])); ?>" class="btn btn-primary"><?php echo htmlspecialchars($entreprise['phone']); ?></a></li>
            <?php endif; ?>
            <?php if (!empty($entreprise['phone2'])): ?>
              <li><strong><?php echo htmlspecialchars($traductions[$lang]['phone2']); ?></strong> <a href="tel:<?php echo htmlspecialchars(preg_replace('/\\s+/', '', $entreprise['phone2'])); ?>" class="btn btn-primary"><?php echo htmlspecialchars($entreprise['phone2']); ?></a></li>
            <?php endif; ?>
            <?php if (!empty($entreprise['ncc'])): ?>
              <li><strong><?php echo htmlspecialchars($traductions[$lang]['ncc']); ?></strong> <a href="tel:<?php echo htmlspecialchars(preg_replace('/\\s+/', '', $entreprise['ncc'])); ?>" class="btn btn-primary"><?php echo htmlspecialchars($entreprise['ncc']); ?></a></li>
            <?php endif; ?>
            <?php if (!empty($entreprise['boa'])): ?>
              <li><strong><?php echo htmlspecialchars($traductions[$lang]['boa']); ?></strong> <a href="tel:<?php echo htmlspecialchars(preg_replace('/\\s+/', '', $entreprise['boa'])); ?>" class="btn btn-primary"><?php echo htmlspecialchars($entreprise['boa']); ?></a></li>
            <?php endif; ?>
            <li>
              <strong><?php echo htmlspecialchars($traductions[$lang]['address']); ?></strong>
              <?php
                $parties_adresse = array_filter([$adresse_affiche, $entreprise['postal_code'] . ' ' . $ville_affiche, $pays_affiche]);
                echo htmlspecialchars(implode(', ', $parties_adresse));
              ?>
            </li>
          </ul>
          <footer><?php echo htmlspecialchars($traductions[$lang]['scan_footer']); ?></footer>
        </section>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" referrerpolicy="no-referrer"></script>
    <script>
      (function() {
        var url_logo_qr = <?php echo json_encode($url_logo_qr); ?>;
        var message_lien_copie = <?php echo json_encode($traductions[$lang]['link_copied']); ?>;

        // Sélecteur de langue
        var select_lang = document.getElementById('select_lang');
        if (select_lang) {
          select_lang.addEventListener('change', function() {
            var params = new URLSearchParams(window.location.search);
            params.set('lang', this.value);
            window.location.search = params.toString();
          });
        }

        function generer_code_qr() {
          var conteneur = document.getElementById('qrcode');
          if (!conteneur) return;
          var url_cible = conteneur.getAttribute('data-url');
          var taille = Math.min(600, Math.floor(Math.min(conteneur.clientWidth || 600, window.innerWidth - 60)));
          if (!taille || taille < 240) taille = 320;
          var facteur_pixel = Math.ceil(window.devicePixelRatio || 2);
          var taille_rendu = Math.max(512, taille * facteur_pixel);
          if (typeof QRCode === 'undefined') {
            console.error('Bibliothèque QRCode non chargée.');
            return;
          }
          // Nettoyer le conteneur au cas où
          while (conteneur.firstChild) conteneur.removeChild(conteneur.firstChild);

          new QRCode(conteneur, {
            text: url_cible,
            width: taille_rendu,
            height: taille_rendu,
            correctLevel: QRCode.CorrectLevel.H
          });

          // Forcer l'affichage à la taille visuelle souhaitée
          var element_rendu = conteneur.querySelector('canvas, img');
          if (element_rendu) {
            element_rendu.style.width = taille + 'px';
            element_rendu.style.height = taille + 'px';
          }

          // Une fois généré, tenter d'incruster le logo
          if (url_logo_qr) {
            essayer_composer_logo(conteneur, url_logo_qr);
          }

          function url_donnees_depuis_qr() {
            var image = conteneur.querySelector('img');
            if (image && image.src) return image.src;
            var toile = conteneur.querySelector('canvas');
            if (toile && toile.toDataURL) return toile.toDataURL('image/png');
            return '';
          }

          document.getElementById('btnDownloadQr').addEventListener('click', function() {
            var url_donnees = url_donnees_depuis_qr();
            // Si le logo n'a pas pu être incrusté (CORS), on tente une composition locale au moment du téléchargement
            if ((!url_donnees || (url_logo_qr && !conteneur.querySelector('img'))) && url_logo_qr) {
              composer_vers_data_url(conteneur, url_logo_qr, function(url_sortie) {
                if (!url_sortie) return;
                declencher_telechargement(url_sortie);
              });
              return;
            }
            if (!url_donnees) return;
            declencher_telechargement(url_donnees);
          });

          document.getElementById('btnCopyLink').addEventListener('click', function() {
            navigator.clipboard.writeText(url_cible).then(function() {
              var precedent = document.getElementById('btnCopyLink').textContent;
              document.getElementById('btnCopyLink').textContent = message_lien_copie;
              setTimeout(function(){ document.getElementById('btnCopyLink').textContent = precedent; }, 1200);
            });
          });

          function declencher_telechargement(lien_href) {
            var lien_el = document.createElement('a');
            lien_el.href = lien_href;
            lien_el.download = 'qr-<?php echo $entreprise_slug; ?>.png';
            document.body.appendChild(lien_el);
            lien_el.click();
            lien_el.remove();
          }
        }

        function charger_bibliotheque_qr_puis_generer() {
          if (typeof QRCode !== 'undefined') { generer_code_qr(); return; }
          var script1 = document.createElement('script');
          script1.src = 'https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js';
          script1.onload = generer_code_qr;
          script1.onerror = function() {
            var script2 = document.createElement('script');
            script2.src = 'https://unpkg.com/qrcodejs@1.0.0/qrcode.min.js';
            script2.onload = generer_code_qr;
            script2.onerror = function(){ console.error('Impossible de charger la librairie QRCode depuis les CDN.'); };
            document.head.appendChild(script2);
          };
          document.head.appendChild(script1);
        }

        function essayer_composer_logo(conteneur, url_logo) {
          // Essayez de convertir l'élément QR en canvas, puis dessiner le logo au centre
          composer_vers_data_url(conteneur, url_logo, function(url_sortie, succes) {
            if (succes && url_sortie) {
              var image_sortie = new Image();
              image_sortie.src = url_sortie;
              while (conteneur.firstChild) conteneur.removeChild(conteneur.firstChild);
              conteneur.appendChild(image_sortie);
            } else {
              // Fallback: simple overlay DOM (ne sera pas dans l'image téléchargée si CORS bloque)
              superposer_logo_dom(conteneur, url_logo);
            }
          });
        }

        function composer_vers_data_url(conteneur, url_logo, cb) {
          var image = conteneur.querySelector('img');
          var toile = conteneur.querySelector('canvas');
          var toile_base;

          function traiter_avec_toile(toile_temp) {
            var contexte = toile_temp.getContext('2d');
            var cote = Math.min(toile_temp.width, toile_temp.height);

            var logo = new Image();
            logo.crossOrigin = 'anonymous';
            logo.onload = function() {
              var ratio = (logo.naturalHeight || logo.height) / (logo.naturalWidth || logo.width);
              var logo_largeur = Math.round(cote * 0.36);
              var logo_hauteur = Math.round(logo_largeur * ratio);
              var hauteur_max = Math.round(cote * 0.28);
              if (logo_hauteur > hauteur_max) {
                var echelle = hauteur_max / logo_hauteur;
                logo_largeur = Math.round(logo_largeur * echelle);
                logo_hauteur = Math.round(logo_hauteur * echelle);
              }
              var x_logo = Math.round((toile_temp.width - logo_largeur) / 2);
              var y_logo = Math.round((toile_temp.height - logo_hauteur) / 2);

              dessiner_rectangle_arrondi(contexte, x_logo, y_logo, logo_largeur, logo_hauteur, Math.round(Math.min(logo_largeur, logo_hauteur) * 0.18), '#fff');
              contexte.drawImage(logo, x_logo, y_logo, logo_largeur, logo_hauteur);
              try {
                var url_sortie = toile_temp.toDataURL('image/png');
                cb(url_sortie, true);
              } catch (e) {
                console.warn('toDataURL bloqué (CORS). Overlay DOM utilisé.');
                cb(null, false);
              }
            };
            logo.onerror = function() { cb(null, false); };
            logo.src = url_logo;
          }

          if (toile) {
            // Déjà en canvas
            toile_base = document.createElement('canvas');
            toile_base.width = toile.width;
            toile_base.height = toile.height;
            var contexte_base = toile_base.getContext('2d');
            contexte_base.drawImage(toile, 0, 0);
            traiter_avec_toile(toile_base);
            return;
          }

          if (image) {
            if (!image.complete) {
              image.addEventListener('load', function(){ composer_vers_data_url(conteneur, url_logo, cb); });
              return;
            }
            toile_base = document.createElement('canvas');
            toile_base.width = image.naturalWidth || image.width;
            toile_base.height = image.naturalHeight || image.height;
            var contexte_base2 = toile_base.getContext('2d');
            contexte_base2.drawImage(image, 0, 0);
            traiter_avec_toile(toile_base);
            return;
          }

          // Pas encore prêt, réessayer prochain tick
          setTimeout(function(){ composer_vers_data_url(conteneur, url_logo, cb); }, 50);
        }

        function dessiner_rectangle_arrondi(contexte, x, y, largeur, hauteur, rayon, couleur_remplissage) {
          contexte.save();
          contexte.beginPath();
          contexte.moveTo(x + rayon, y);
          contexte.arcTo(x + largeur, y, x + largeur, y + hauteur, rayon);
          contexte.arcTo(x + largeur, y + hauteur, x, y + hauteur, rayon);
          contexte.arcTo(x, y + hauteur, x, y, rayon);
          contexte.arcTo(x, y, x + largeur, y, rayon);
          contexte.closePath();
          contexte.fillStyle = couleur_remplissage;
          contexte.fill();
          contexte.restore();
        }

        function superposer_logo_dom(conteneur, url_logo) {
          if (conteneur.querySelector('.qr-logo')) return;
          var superposition = document.createElement('img');
          superposition.src = url_logo;
          superposition.alt = 'Logo';
          superposition.className = 'qr-logo';
          conteneur.appendChild(superposition);
        }

        charger_bibliotheque_qr_puis_generer();
      })();
    </script>
  </body>
</html>
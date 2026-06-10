<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WebTodo — Gestionnaire de tâches</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="wrapper">

  <!-- ═══════════════════════════════════════════════════════
       SIDEBAR
  ═══════════════════════════════════════════════════════ -->
  <aside class="sidebar">

    <!-- Logo -->
    <div class="logo">
      <div class="logo-icon">✦</div>
      <h1>Web<span>Todo</span></h1>
    </div>

    <!-- Statistiques rapides -->
    <div class="sidebar-section">
      <h3>Aperçu</h3>
      <div class="stats-grid">
        <div class="stat-card total">
          <div class="num"><?= $stats['total'] ?></div>
          <div class="lbl">Total</div>
        </div>
        <div class="stat-card done">
          <div class="num"><?= $stats['terminees'] ?></div>
          <div class="lbl">Terminées</div>
        </div>
        <div class="stat-card doing">
          <div class="num"><?= $stats['en_cours'] ?></div>
          <div class="lbl">En cours</div>
        </div>
        <div class="stat-card urgent">
          <div class="num"><?= $stats['urgentes'] ?></div>
          <div class="lbl">Urgentes</div>
        </div>
      </div>
    </div>

    <!-- Filtres par statut -->
    <div class="sidebar-section">
      <h3>Filtrer par statut</h3>
      <?php
      $statuts = ['tous'=>'🗂 Toutes','en_attente'=>'⏳ En attente','en_cours'=>'🔄 En cours','terminee'=>'✅ Terminées'];
      foreach ($statuts as $val => $label): ?>
        <a href="?statut=<?= $val ?>">
          <button class="filter-btn <?= $filtreStatut === $val ? 'active' : '' ?>">
            <?= $label ?>
          </button>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Filtres par priorité -->
    <div class="sidebar-section">
      <h3>Filtrer par priorité</h3>
      <?php
      $prios = ['tous'=>'◈ Toutes','haute'=>'🔴 Haute','normale'=>'🔵 Normale','basse'=>'⚪ Basse'];
      foreach ($prios as $val => $label): ?>
        <a href="?priorite=<?= $val ?>">
          <button class="filter-btn <?= $filtrePriorite === $val ? 'active' : '' ?>">
            <?= $label ?>
          </button>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Catégories -->
    <div class="sidebar-section">
      <h3>Catégories</h3>
      <?php foreach ($categories as $cat): ?>
        <div class="cat-item">
          <span class="cat-name">
            <span class="cat-dot" style="background:<?= htmlspecialchars($cat['couleur']) ?>"></span>
            <?= htmlspecialchars($cat['nom']) ?>
          </span>
          <form action="controllers/categories.php" method="POST" style="display:inline"
                onsubmit="return confirm('Supprimer cette catégorie ?')">
            <input type="hidden" name="action" value="supprimer">
            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
            <button type="submit" class="cat-del" title="Supprimer">✕</button>
          </form>
        </div>
      <?php endforeach; ?>

      <!-- Nouvelle catégorie -->
      <form action="controllers/categories.php" method="POST" class="cat-form">
        <input type="hidden" name="action" value="creer">
        <input type="text" name="nom" placeholder="Nouvelle…" required maxlength="50">
        <input type="color" name="couleur" value="#7c6af7" title="Couleur">
        <button type="submit" title="Ajouter">+</button>
      </form>
    </div>

  </aside>

  <!-- ═══════════════════════════════════════════════════════
       MAIN CONTENT
  ═══════════════════════════════════════════════════════ -->
  <main class="main">

    <!-- Header -->
    <div class="main-header">
      <div>
        <h2>Mes Tâches</h2>
        <p><?= date('l d F Y') ?> · <?= count($taches) ?> tâche(s) affichée(s)</p>
      </div>
    </div>

    <!-- Notifications flash -->
    <?php if ($succes): ?>
      <div class="toast succes"><?= htmlspecialchars($succes) ?></div>
    <?php endif; ?>
    <?php if ($erreur): ?>
      <div class="toast erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <!-- ═══ Formulaire : Ajouter une tâche ═══ -->
    <div class="task-form-card">
      <h3>+ Nouvelle tâche</h3>
      <form action="controllers/taches.php" method="POST">
        <input type="hidden" name="action" value="creer">
        <div class="form-grid">
          <div class="form-group full">
            <label for="titre">Titre *</label>
            <input type="text" id="titre" name="titre" placeholder="Que devez-vous faire ?" required maxlength="255">
          </div>
          <div class="form-group full">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Détails supplémentaires…"></textarea>
          </div>
          <div class="form-group">
            <label for="statut">Statut</label>
            <select id="statut" name="statut">
              <option value="en_attente">⏳ En attente</option>
              <option value="en_cours">🔄 En cours</option>
              <option value="terminee">✅ Terminée</option>
            </select>
          </div>
          <div class="form-group">
            <label for="priorite">Priorité</label>
            <select id="priorite" name="priorite">
              <option value="normale" selected>🔵 Normale</option>
              <option value="haute">🔴 Haute</option>
              <option value="basse">⚪ Basse</option>
            </select>
          </div>
          <div class="form-group">
            <label for="categorie_id">Catégorie</label>
            <select id="categorie_id" name="categorie_id">
              <option value="">— Aucune —</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="date_echeance">Échéance</label>
            <input type="date" id="date_echeance" name="date_echeance">
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">✦ Ajouter la tâche</button>
        </div>
      </form>
    </div>

    <!-- ═══ Groupes de tâches ═══ -->
    <?php
    $groupLabels = [
      'en_cours'   => ['🔄 En cours',    count($tachesParStatut['en_cours'])],
      'en_attente' => ['⏳ En attente',   count($tachesParStatut['en_attente'])],
      'terminee'   => ['✅ Terminées',    count($tachesParStatut['terminee'])],
    ];

    foreach ($groupLabels as $statut => [$label, $nb]):
      if (($filtreStatut !== 'tous' && $filtreStatut !== $statut) && $nb === 0) continue;
    ?>
      <div class="tasks-section">
        <h3><?= $label ?> <span class="count"><?= $nb ?></span></h3>

        <?php if ($nb === 0): ?>
          <div class="empty-state">
            <div class="icon">🌿</div>
            <p>Aucune tâche dans cette catégorie.</p>
          </div>
        <?php else: ?>
          <div class="task-list">
            <?php foreach ($tachesParStatut[$statut] as $t):
              $isDone    = $t['statut'] === 'terminee';
              $nextStatut = $isDone ? 'en_attente' : 'terminee';
              $today     = date('Y-m-d');
              $overdue   = $t['date_echeance'] && $t['date_echeance'] < $today && !$isDone;
            ?>
              <div class="task-card priorite-<?= $t['priorite'] ?> <?= $isDone ? 'done' : '' ?>">

                <!-- Toggle terminée -->
                <form action="controllers/taches.php" method="POST" class="status-form">
                  <input type="hidden" name="action" value="statut">
                  <input type="hidden" name="id"     value="<?= $t['id'] ?>">
                  <input type="hidden" name="statut" value="<?= $nextStatut ?>">
                  <button type="submit" class="status-btn" title="Marquer <?= $isDone ? 'non terminée' : 'terminée' ?>">
                    <?= $isDone ? '✓' : '' ?>
                  </button>
                </form>

                <!-- Contenu -->
                <div class="task-content">
                  <div class="task-title"><?= htmlspecialchars($t['titre']) ?></div>
                  <div class="task-meta">
                    <!-- Priorité -->
                    <span class="badge badge-prio-<?= $t['priorite'] ?>">
                      <?= ['haute'=>'🔴 Haute','normale'=>'🔵 Normale','basse'=>'⚪ Basse'][$t['priorite']] ?>
                    </span>
                    <!-- Catégorie -->
                    <?php if ($t['categorie_nom']): ?>
                      <span class="cat-badge" style="background:<?= htmlspecialchars($t['categorie_couleur']) ?>88;color:<?= htmlspecialchars($t['categorie_couleur']) ?>">
                        <?= htmlspecialchars($t['categorie_nom']) ?>
                      </span>
                    <?php endif; ?>
                    <!-- Date échéance -->
                    <?php if ($t['date_echeance']): ?>
                      <span class="task-date <?= $overdue ? 'overdue' : '' ?>">
                        <?= $overdue ? '⚠' : '📅' ?> <?= date('d/m/Y', strtotime($t['date_echeance'])) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <?php if ($t['description']): ?>
                    <div style="font-size:0.8rem;color:var(--muted);margin-top:6px;line-height:1.4">
                      <?= nl2br(htmlspecialchars(mb_substr($t['description'], 0, 120))) ?>
                      <?= mb_strlen($t['description']) > 120 ? '…' : '' ?>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- Actions -->
                <div class="task-actions">
                  <a href="controllers/taches.php?action=modifier&id=<?= $t['id'] ?>">
                    <button class="icon-btn edit" title="Modifier">✏</button>
                  </a>
                  <form action="controllers/taches.php" method="POST"
                        onsubmit="return confirm('Supprimer cette tâche ?')">
                    <input type="hidden" name="action" value="supprimer">
                    <input type="hidden" name="id"     value="<?= $t['id'] ?>">
                    <button type="submit" class="icon-btn del" title="Supprimer">🗑</button>
                  </form>
                </div>

              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>

  </main>
</div>

<script>
  // Auto-masquer les notifications après 4 secondes
  setTimeout(() => {
    document.querySelectorAll('.toast').forEach(t => {
      t.style.transition = 'opacity 0.5s';
      t.style.opacity = '0';
      setTimeout(() => t.remove(), 500);
    });
  }, 4000);
</script>

</body>
</html>

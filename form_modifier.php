<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier la tâche — WebTodo</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 24px; }
    .edit-card {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 36px;
      width: 100%;
      max-width: 600px;
      box-shadow: var(--shadow);
    }
    .edit-card h2 {
      font-size: 1.4rem;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .edit-card h2 span { color: var(--accent2); }
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: var(--muted);
      font-size: 0.875rem;
      margin-bottom: 20px;
      transition: all 0.2s;
    }
    .back-link:hover { color: var(--text); }
  </style>
</head>
<body>
<div class="edit-card">
  <a href="../index.php" class="back-link">← Retour à la liste</a>
  <h2>✏ Modifier <span><?= htmlspecialchars(mb_substr($tache['titre'], 0, 30)) ?>…</span></h2>

  <form action="../controllers/taches.php?id=<?= $tache['id'] ?>" method="POST">
    <input type="hidden" name="action" value="modifier">
    <input type="hidden" name="id"     value="<?= $tache['id'] ?>">

    <div class="form-grid">
      <div class="form-group full">
        <label for="titre">Titre *</label>
        <input type="text" id="titre" name="titre"
               value="<?= htmlspecialchars($tache['titre']) ?>" required maxlength="255">
      </div>
      <div class="form-group full">
        <label for="description">Description</label>
        <textarea id="description" name="description"><?= htmlspecialchars($tache['description'] ?? '') ?></textarea>
      </div>
      <div class="form-group">
        <label for="statut">Statut</label>
        <select id="statut" name="statut">
          <?php foreach (['en_attente'=>'⏳ En attente','en_cours'=>'🔄 En cours','terminee'=>'✅ Terminée'] as $v => $l): ?>
            <option value="<?= $v ?>" <?= $tache['statut'] === $v ? 'selected' : '' ?>><?= $l ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="priorite">Priorité</label>
        <select id="priorite" name="priorite">
          <?php foreach (['haute'=>'🔴 Haute','normale'=>'🔵 Normale','basse'=>'⚪ Basse'] as $v => $l): ?>
            <option value="<?= $v ?>" <?= $tache['priorite'] === $v ? 'selected' : '' ?>><?= $l ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="categorie_id">Catégorie</label>
        <select id="categorie_id" name="categorie_id">
          <option value="">— Aucune —</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $tache['categorie_id'] == $cat['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="date_echeance">Échéance</label>
        <input type="date" id="date_echeance" name="date_echeance"
               value="<?= htmlspecialchars($tache['date_echeance'] ?? '') ?>">
      </div>
    </div>

    <div class="form-actions" style="display:flex;gap:10px;margin-top:20px">
      <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
      <a href="../index.php">
        <button type="button" class="btn" style="background:var(--bg3);color:var(--muted)">Annuler</button>
      </a>
    </div>
  </form>
</div>
</body>
</html>

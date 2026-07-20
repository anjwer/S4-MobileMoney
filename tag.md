c'est pour envoyer un tag hahaha


# Git Tags - L'essentiel

## Concept

- Développez normalement avec plusieurs commits.
- Quand une version est **terminée**, le **dernier commit** devient la version officielle.
- Créez un **tag** sur ce dernier commit.
- Continuez ensuite le développement jusqu'à la prochaine version.

Exemple :

```text
A ---- B ---- C ---- D
                   ^
                v1.0.0
```

Le tag `v1.0.0` pointe uniquement vers le commit `D`.

---

## Workflow

### 1. Faire le dernier commit de la version

```bash
git add .
git commit -m "Préparation de la version 1.0.0"
```

### 2. Envoyer les commits

```bash
git push origin main
```

### 3. Créer le tag

```bash
git tag -a v1.0.0 -m "Première version stable"
```

### 4. Envoyer le tag

```bash
git push origin v1.0.0
```

---

## Nouvelle version

Continuez à développer normalement avec de nouveaux commits.

Quand la version suivante est prête :

```bash
git push origin main
git tag -a v1.1.0 -m "Version 1.1.0"
git push origin v1.1.0
```

---

## À retenir

> **Un tag = une version publiée = un seul commit (le dernier de la version).**
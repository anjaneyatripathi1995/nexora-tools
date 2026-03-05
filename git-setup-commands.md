# Git setup – Nexora Tools

Run these from the **project root** (e.g. `c:\xampp\htdocs\nexora-tools`).

## If the repo is not initialized

```bash
git init
git add .
git commit -m "Initial Nexora Tools Laravel Setup"
git branch -M main
git remote add origin https://github.com/anjaneyatripathi1995/nexora-tools.git
git push -u origin main
```

## If the repo is already initialized (e.g. already has commits)

```bash
git add .
git status
git commit -m "Initial Nexora Tools Laravel Setup"
git branch -M main
git remote add origin https://github.com/anjaneyatripathi1995/nexora-tools.git
git push -u origin main
```

If `origin` already exists:

```bash
git remote set-url origin https://github.com/anjaneyatripathi1995/nexora-tools.git
git push -u origin main
```

## Set `main` as default on GitHub

1. Open https://github.com/anjaneyatripathi1995/nexora-tools
2. **Settings** → **General**
3. Under **Default branch**, choose **main** and **Update**.

## One-liner (fresh init)

```bash
git init && git add . && git commit -m "Initial Nexora Tools Laravel Setup" && git branch -M main && git remote add origin https://github.com/anjaneyatripathi1995/nexora-tools.git && git push -u origin main
```

You will be prompted for GitHub credentials (or use SSH/HTTPS token).

## Initialisation du projet

` brew install shopt `
`symfony new gpt_art_describe  --webapp`  
ou  
``` symfony new --dir=guestbook --webapp --version=7.1    
  rm -rf guestbook/.git
  shopt -s dotglob
  mv guestbook/* ./
  rm -rf guestbook/
```

puis `composer install `  


Pour aller sur la branche d'une issue : ``` git fetch origin                             
git checkout 1-initialiser-projet ```


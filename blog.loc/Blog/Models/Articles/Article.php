<?php

namespace Blog\Models\Articles;

use Blog\Models\ActiveRecordEntity;
use Blog\Models\Users\User;
use Blog\Exceptions\InvalidArgumentException;

class Article extends ActiveRecordEntity
{
    protected $name;
    protected $text;
    protected $authorId;
    protected $createdAt;

    public function getName(): string { return $this->name; }
    public function getText(): string { return $this->text; }
    public function getAuthor(): User { return User::getById($this->authorId); }
    protected static function getTableName(): string { return 'articles'; }

    public function setName(string $newName){ $this->name = $newName; }
    public function setText(string $newText){ $this->text = $newText; }
    public function setAuthor(User $newAuthor){ $this->authorId = $newAuthor->getId(); }

    public static function create(array $fields, User $author): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('У статьи должно быть название');
        }
    
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Статья не может быть пустой');
        }
    
        $article = new Article();
    
        $article->setAuthor($author);
        $article->setName($fields['name']);
        $article->setText($fields['text']);
    
        $article->save();
    
        return $article;
    }

    public function updateFromArray(array $fields)
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('У статьи должно быть название');
        }
    
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Статья не может быть пустой');
        }
        
        $this->setName($fields['name']);
        $this->setText($fields['text']);

        $this->save();
        return $this;
    }
}

?>
<?php namespace core;

class Database {
  public function __construct(string $host, string $username, string $password) {
    $opts = [
      \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
      \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
      \PDO::ATTR_EMULATE_PREPARES => false
    ];
    $this->db = new \PDO("mysql:host=$host;dbname=phpsite;charset=utf8", $username, $password, $opts);
  }

  public function get_username(int $id): ?string {
    if (!$this->stmt_get_username) {
      $this->stmt_get_username = $this->db->prepare("SELECT name FROM users WHERE id=?");
    }
    $this->stmt_get_username->execute([$id]);
    $row = $this->stmt_get_username->fetch();
    $this->stmt_get_username->closeCursor();
    return $row ? $row["name"] : null;
  }

  public function get_user_auth_data(string $username): ?array {
    if (!$this->stmt_get_user_auth_data) {
      $this->stmt_get_user_auth_data = $this->db->prepare("SELECT id,hash,salt FROM users WHERE name=?");
    }
    $this->stmt_get_user_auth_data->execute([$username]);
    $row = $this->stmt_get_user_auth_data->fetch();
    $this->stmt_get_user_auth_data->closeCursor();
    return $row ? $row : null; //id,hash,salt
  }

  public function add_user_auth_data(string $username, string $hash, string $salt): void {
    if (!$this->stmt_add_user_auth_data) {
      $this->stmt_add_user_auth_data = $this->db->prepare("INSERT INTO users (name,hash,salt) VALUES (?,?,?)");
    }
    $this->stmt_add_user_auth_data->execute([$username, $hash, $salt]);
    $this->stmt_add_user_auth_data->closeCursor();
  }

  public function add_atricle(int $author_id, string $theme, string $url_theme, string $scope, array $content): int {
    if (!$this->stmt_add_article) {
      $this->stmt_add_article = $this->db->prepare("INSERT INTO articles (author_id,theme,url_theme,scope,content) VALUES (?,?,?,?,?);");
    }
    $this->db->beginTransaction();
    $this->stmt_add_article->execute([$author_id, $theme, $url_theme, $scope, json_encode($content)]);
    $row = $this->db->query("SELECT LAST_INSERT_ID() as id")->fetch();
    $this->db->commit();
    $this->stmt_add_article->closeCursor();
    return $row["id"];
  }
  public function get_article($author_id): ?array {
    if (!$this->stmt_get_article) {
      $this->stmt_get_article = $this->db->prepare("SELECT author_id,theme,url_theme,scope,content,timestamp FROM articles WHERE id=?");
    }
    $this->stmt_get_article->execute([$author_id]);
    $row = $this->stmt_get_article->fetch();
    $this->stmt_get_article->closeCursor();
    return $row ? $row : null;
  }

  public function get_articles(): array {
    if (!$this->stmt_get_articles) {
      $this->stmt_get_articles = $this->db->prepare("SELECT id,author_id,theme,url_theme,scope,timestamp FROM articles");
    }
    $result = [];
    $this->stmt_get_articles->execute();
    while ($row = $this->stmt_get_articles->fetch()) {
      array_push($result, $row);
    }
    $this->stmt_get_articles->closeCursor();
    return $result;
  }

  public function get_user_articles(int $author_id): array {
    if (!$this->stmt_get_user_articles) {
      $this->stmt_get_user_articles = $this->db->prepare("SELECT id,theme,url_theme,scope,timestamp FROM articles WHERE author_id=?");
    }
    $result = [];
    $this->stmt_get_user_articles->execute([$author_id]);
    while ($row = $this->stmt_get_user_articles->fetch()) {
      array_push($result, $row);
    }
    $this->stmt_get_user_articles->closeCursor();
    return $result;
  }

  public function delete_article(int $article_id): void {
    if (!$this->stmt_delete_article) {
      $this->stmt_delete_article = $this->db->prepare("DELETE FROM articles WHERE id=?");
    }
    $this->stmt_delete_article->execute([$article_id]);
    $this->stmt_delete_article->closeCursor();
  }

  public function get_article_author(int $article_id): ?int {
    if (!$this->stmt_get_article_author) {
      $this->stmt_get_article_author = $this->db->prepare("SELECT author_id FROM articles WHERE id=?");
    }
    $this->stmt_get_article_author->execute([$article_id]);
    $row = $this->stmt_get_article_author->fetch();
    $this->stmt_get_article_author->closeCursor();
    return $row ? intval($row["author_id"]) : null;
  }

  public function update_article(int $article_id, string $theme, string $url_theme, string $scope, array $content): void {
    if (!$this->stmt_update_article) {
      $this->stmt_update_article = $this->db->prepare("UPDATE articles SET theme=?,url_theme=?,scope=?,content=? WHERE id=?");
    }
    $this->stmt_update_article->execute([$theme, $url_theme, $scope, json_encode($content), $article_id]);
    $this->stmt_update_article->closeCursor();
  }

  private $db = null;
  private $stmt_get_username = null;
  private $stmt_get_user_auth_data = null;
  private $stmt_add_user_auth_data = null;
  private $stmt_add_article = null;
  private $stmt_get_article = null;
  private $stmt_get_articles = null;
  private $stmt_get_user_articles = null;
  private $stmt_delete_article = null;
  private $stmt_get_article_author = null;
  private $stmt_update_article = null;
}


?>
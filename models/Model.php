<?php

namespace App\Models;
use App\Core\Db;
use PDOStatement;

class Model extends Db
{
    protected ?string $table = null;

    private ?Db $db = null;

    /**
     * Fonction qui envoie une requete en base de données
     *
     * @param string $query
     * @param array $attributs
     * @return PDOStatement|boolean
     */
    public function runQuery(string $query, array $attributs = []): PDOStatement|bool
    {
        // On récupère l'instance de Db
        $this->db = Db::getInstance();

        // On vérifie si on a des attributs
        if ($attributs != null) {
            $query = $this->db->prepare($query);
            $query->execute($attributs);

            return $query;
        } else {
            // Requete simple
            return $this->db->query($query);
        }
    }

    /**
     * Fonction qui récupère toutes les entrées d'une table
     *
     * @return array
     */
    public function findAll(): array
    {
        $query = $this->runQuery("SELECT * FROM $this->table");

        return $query->fetchAll();
    }

    public function findBy(array $criteres): array
    {
        // SELECT * FROM poste WHERE titre = :titre AND id = :id
        $champs = [];
        $valeurs = [];

        foreach ($criteres as $key => $value) {
            $champs[] = "$key = ?";
            $valeurs[] = $value;
        }

        $listeChamp = implode(' AND ', $champs);

        // On execute la requete
        return $this->runQuery("SELECT * FROM $this->table WHERE $listeChamp", $valeurs)->fetchAll();
    }

    
    public function find(int $id): array|bool
    {
        return $this->runQuery("SELECT * FROM $this->table WHERE id = ?", [$id])->fetch();
    }

    /**
     * Création d'une entrée en base de données
     *
     * @param self $model
     * @return void
     */
    public function create(self $model): PDOStatement|bool
    {
        // INSERT INTO poste (titre, description, actif) VALUES (?,?,?)
        $champs = [];
        $marqueurSql = [];
        $valeurs = [];

        foreach ($model as $key => $value) {
            if ($key != 'table' && $key != 'db' &&  $value !== null) {
                $champs[] = $key;
                $marqueurSql[] = '?';
                $valeurs[] = $value;
            }
        }

        $listeChamp = implode(', ', $champs);
        $listeMarqueurSql = implode(', ', $marqueurSql);

        // On execute la requête SQL
        return $this->runQuery("INSERT INTO $this->table ($listeChamp) VALUES ($listeMarqueurSql)",$valeurs);
    }

    /**
     * Fonction qui hydrate un poste a partir d'un tableau associatifs
     *
     * @param array $donnees
     * @return self
     */
    public function hydrate(array $donnees): self
    {
        foreach($donnees as $key => $value){
            // On récupère le nom du setter qui correspond à la clé (key)
            $setter ='set' . ucwords($key);

            // On vérifie l'existance du setter crée
            if(method_exists($this, $setter)){
                // Si OK, on appelle (execute) le setter
                $this->$setter($value);
            }

        }
        return $this;
    }

    /**
     * Fonction qui met a jour les valuers des attributs d'un poste selon son id
     *
     * @param integer $id
     * @param self $model
     * @return PDOStatement|boolean
     */
    public function update(int $id, self $model): PDOStatement|bool
    {
        $champs = [];
        $valeurs = [];

        foreach ($model as $champ => $valeur) {
            if ($champ != 'table' && $champ != 'db' &&  $valeur !== null) {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }

        $valeurs[] = $id;

        // On transforme le tableau $champs en string
        $listeChamp = implode(', ', $champs);

        // On execute la requête SQL
        return $this->runQuery("UPDATE $this->table SET $listeChamp WHERE id = ?",$valeurs);
    }

    public function delete(int $id)
    {
        return $this->runQuery("DELETE FROM $this->table WHERE id = ?", [$id]);
    }
}
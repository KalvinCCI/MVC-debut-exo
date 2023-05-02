<?php

namespace App\Core;

class Form
{
    /**
     * Stock le code HTML du formulaire
     *
     * @var string
     */
    private $formCode = '';

    /**
     * Validation du formulaire
     *
     * @param array $form issue du $_GET ou $_POST (tableau associatif)
     * @param array $champs les champs obligatoire pour valider le formulaire
     * @return boolean
     */
    public function validate(array $form, array $champs): bool
    {
        // On parcourt les champs
        foreach ($champs as $champ) {
            // Si le champ est absent ou vide dans le formulaire
            if ( isset($form[$champ]) === false || empty($form[$champ]) || strlen(trim($form[$champ])) == 0 ) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Ouvre la balise form HTML
     *
     * @param string $action action du formulaire
     * @param string $method methode utilisee par le formulaire
     * @param array $attributs attrbiuts HTML a ajouter a la balise form
     * @return self
     */
    public function startForm(string $action = '#', string $method = 'POST', array $attributs = []): self
    {
        // On cree la balise form
        $this->formCode .= "<form action=\"$action\" method=\"$method\"";

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->addAttributes($attributs) . '>' : '>';

        return $this;
    }

    public function endForm(): self
    {
        $this->formCode .= '</form>';

        return $this;
    }

    public function startDiv(array $attributs = []): self
    {
        $this->formCode .= '<div';

        $this->formCode .= $attributs?$this->addAttributes($attributs).'>':'>';
        
        return $this;
    }

    public function endDiv():self
    {
        $this->formCode .= '</div>';

        return $this;
    }

    public function addLabel(string $for, string $text, array $attributs = []): self
    {
        $this->formCode .= "<label for=\"$for\"";
        $this->formCode .= $attributs?$this->addAttributes($attributs):'';
        $this->formCode .= ">$text</label>";

        return $this;
    }

    public function addInput(string $type, string $name, array $attributs=[]): self
    {
        $this->formCode .= "<input type=\"$type\" name=\"$name\"";
        $this->formCode .= $attributs?$this->addAttributes($attributs).'>':'>';
        
        return $this;
    }

    public function addButton(string $text, array $attributs = []): self
    {
        $this->formCode .= "<button";
        $this->formCode .= $attributs?$this->addAttributes($attributs):'';
        $this->formCode .= ">$text</button>";
        
        return $this;
    }

    /**
     * Ajoute les attributs HTML les éléments HTML
     *
     * @param array $attributs exemple data = ['placeholder' => 'Test', 'required' => true]
     * @return string
     */
    public function addAttributes(array $attributs): string
    {
        // On ouvre une chaine de caractere vide
        $str = '';

        $attrCourt = ['required', 'readonly', 'multiple', 'disable', 'checked', 'autofocus', 'novalidate', 'formnovalidate'];
        // On boucle sur le tableau d'attribut
        foreach ($attributs as $attribut => $value) {
            if ( in_array($attribut, $attrCourt) ) {
                $str .= " $attribut";
            } else {
                $str .= " $attribut=\"$value\"";
            }
        }

        return $str;
    }

    /**
     * Génère le code HTML du formulaire
     *
     * @return string Chaine de caractere du code HTML du form
     */
    public function createForm(): string
    {
        return $this->formCode;
    }

}
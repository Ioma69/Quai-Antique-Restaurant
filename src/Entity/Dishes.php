<?php

namespace App\Entity;

use App\Repository\DishesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishesRepository::class)]
class Dishes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;


    #[ORM\ManyToOne(targetEntity:"App\Entity\Admin", inversedBy:"dishes")]
    #[ORM\JoinColumn(name: "admin_id", referencedColumnName: "id")]
    private $admin;


    #[ORM\ManyToOne(targetEntity:"App\Entity\Categories", inversedBy:"dishes", cascade: ["remove"])]
    #[ORM\JoinColumn(name:"categories_id", referencedColumnName:"id", onDelete: "CASCADE")]

    private $category;

    #[ORM\ManyToMany(targetEntity: "App\Entity\Menu", mappedBy: "meal")]
    private $menu;
 


    public function __toString()
{
    return $this->getTitle();
}



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * Set the value of price
     */
    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

   

    /**
     * Get the value of admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the value of admin
     */
    public function setAdmin($admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get the value of category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     */
    public function setCategory($category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set the value of menu
     */
    public function setMenu($menu): self
    {
        $this->menu = $menu;

        return $this;
    }


}
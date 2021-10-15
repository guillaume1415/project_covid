<?php

declare(strict_types=1);

namespace App\Entity;


use Doctrine\ORM\EntityManager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class Users
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=45)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=500)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $date_at;

    /**
     * @ORM\Column(type="date",nullable=true)
     * @var date
     */
    private $date_birthday;

    /**
     * @ORM\Column(type="boolean",nullable=true,options={"default":false})
     * @var bool
     */
    private $cas_contact;

    /**
     * @ORM\Column(type="boolean",nullable=true,options={"default":false})
     * @var bool
     */
    private $covid_plus;

    /**
     * @ORM\OneToOne(targetEntity=Geolocalisation::class, cascade={"persist", "remove"},nullable=true)
     */
    private $geolocalisation_user;

    /**
     * @ORM\ManyToMany(targetEntity=Messaging::class, inversedBy="users")
     */
    private $messaging;

    public function __construct(EntityManager $em)
    {
        $this->messaging = new ArrayCollection();
        $this->em = $em;
//        $this->date_birthday = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateBirthday()
    {
        return $this->date_birthday;
    }

    public function setDateBirthday(\DateTimeInterface $date_birthday): self
    {
        $this->date_birthday = $date_birthday;

        return $this;
    }

    public function getDateAt()
    {
        return $this->date_at;
    }

    public function setDateAt(\DateTimeInterface $date_at): self
    {
        $this->date_at = $date_at;

        return $this;
    }

    public function getCovidMore()
    {
        return $this->covid_more;
    }

    public function setCovidMore($covid_more): self
    {
        $this->covid_more = $covid_more;
        return $this;
    }

    public function getCasContact()
    {
        return $this->cas_contact;
    }

    public function setCasContact($cas_contact): self
    {
        $this->cas_contact = $cas_contact;

        return $this;
    }

    public function getGeolocalisationUser(): ?geolocalisation
    {
        return $this->geolocalisation_user;
    }

    public function setGeolocalisationUser(?geolocalisation $geolocalisation_user): self
    {
        $this->geolocalisation_user = $geolocalisation_user;

        return $this;
    }

    /**
     * @return Collection|messaging[]
     */
    public function getMessaging(): Collection
    {
        return $this->messaging;
    }

    public function addMessaging(messaging $messaging): self
    {
        if (!$this->messaging->contains($messaging)) {
            $this->messaging[] = $messaging;
        }

        return $this;
    }

    public function removeMessaging(messaging $messaging): self
    {
        if ($this->messaging->contains($messaging)) {
            $this->messaging->removeElement($messaging);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    /**
     * Insert user resgiter
     */
    public function insertUser($name, $first_name, $email, $password,$birth_day){
        $passwordHash = $this->hashPassword($password);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setFirstName($first_name);
        $this->setDateBirthday( new \DateTime($birth_day));
        $this->setDateAt( new \DateTime());
        $this->setName($name);
//        $this->setCasContact(1);
//        $this->setCovidMore(1);
        $this->setPassword($passwordHash);
//        $this->setGeolocalisationUser();
//        var_dump($passwordHash);
//        $query = $this->em->createQuery('SELECT e.password FROM \App\Entity\Users e WHERE e.email = :email ');
//        $query = $this->em->createQuery('INSERT INTO \App\Entity\Users VALUES (name, first_name, email, password) (:name, :first_name, :email, :password) ');
//        $query->setParameters(array(
//            'name' => $name,
//            'first_name' => $first_name,
//            'email' => $email,
//            'passwordHash' => $passwordHash,
//        ));
        $this->em->persist($this);
        $this->em->flush();
        $user_id = $this->getId();
        // TODO START SESSION
//        echo "ok inser";
//        session_start();
//        $_SESSION["success"]['Inscription réussi'];
        return $user_id;
        // $user_id = lastInsertId();
    }

    /**
     *
     */
    public function loginUser($email, $password)
    {
        $query = $this->em->createQuery('SELECT e.password FROM \App\Entity\Users e WHERE e.email = :email ');
        $query->setParameters(array(
            'email' => $email,
        ));
        $user = $query->getResult();

        if ($user && $this->passwordConfirm($password, $user)) {
//            var_dump($user[0]["password"]) . "</br>";
             $this->connect($user);
            return $user;
        }
    }

    /**
     * créer la séssion utilisateur
     */
    public function connect($user)
    {
        session_start();
        $_SESSION['user'] = $user;
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function passwordConfirm($password, $user)
    {
        return password_verify($password, $user[0]["password"]);
    }
}

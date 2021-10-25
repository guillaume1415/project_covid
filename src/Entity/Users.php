<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1483A5E9E9A52300", columns={"geolocalisation_user_id"})})
 * @ORM\Entity
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=32, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=500, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_at", type="datetime", nullable=false)
     */
    private $dateAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_birthday", type="date", nullable=false)
     */
    private $dateBirthday;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="cas_contact", type="boolean", nullable=true)
     */
    private $casContact = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="covid_plus", type="boolean", nullable=true)
     */
    private $covidPlus = '0';

    /**
     * @var \Geolocalisation
     *
     * @ORM\ManyToOne(targetEntity="Geolocalisation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="geolocalisation_user_id", referencedColumnName="id")
     * })
     */
    private $geolocalisationUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Messaging", inversedBy="users")
     * @ORM\JoinTable(name="users_messaging",
     *   joinColumns={
     *     @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="messaging_id", referencedColumnName="id")
     *   }
     * )
     */
    private $messaging;



    /**
     * Constructor
     */
    public function __construct(EntityManager $em )
    {
        $this->messaging = new \Doctrine\Common\Collections\ArrayCollection();
        $this->em = $em;
//        $this->setGeolocalisationUser = $geolocalisationUser;
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateAt(): ?\DateTimeInterface
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeInterface $dateAt): self
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getDateBirthday(): ?\DateTimeInterface
    {
        return $this->dateBirthday;
    }

    public function setDateBirthday(\DateTimeInterface $dateBirthday): self
    {
        $this->dateBirthday = $dateBirthday;

        return $this;
    }

    public function getCasContact(): ?bool
    {
        return $this->casContact;
    }

    public function setCasContact(?bool $casContact): self
    {
        $this->casContact = $casContact;

        return $this;
    }

    public function getCovidPlus(): ?bool
    {
        return $this->covidPlus;
    }

    public function setCovidPlus(?bool $covidPlus): self
    {
        $this->covidPlus = $covidPlus;

        return $this;
    }

    public function getGeolocalisationUser(): ?Geolocalisation
    {
        return $this->geolocalisationUser;
    }

    public function setGeolocalisationUser(?Geolocalisation $geolocalisationUser): self
    {
        $this->geolocalisationUser = $geolocalisationUser;

        return $this;
    }

    /**
     * @return Collection|Messaging[]
     */
    public function getMessaging(): Collection
    {
        return $this->messaging;
    }

    public function addMessaging(Messaging $messaging): self
    {
        if (!$this->messaging->contains($messaging)) {
            $this->messaging[] = $messaging;
        }

        return $this;
    }

    public function removeMessaging(Messaging $messaging): self
    {
        $this->messaging->removeElement($messaging);

        return $this;
    }

    /** test geo */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

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
//        $loca = $this->em->findBy(array(),array('id'=>'DESC'),1,0);
//        $loca = $this->em->find(Geolocalisation::class, 3);
        $passwordHash = $this->hashPassword($password);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setFirstName($first_name);
        $this->setDateBirthday( new \DateTime($birth_day));
        $this->setDateAt( new \DateTime());
        $this->setName($name);
//        $this->setGeolocalisationUser($loca);
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
# Doctrine2 orm bridge for zizaco/entrust

**THIS PACKAGE IS UNDER DEVELOPMENT**

## Configuration

### Installation
Run `$ composer require spotonlive/sl-entrust-doctrine-orm`

**config/app.php**
*Note: It is important that the providers are appended in this order*
```
    'providers' => [
	    (...)
		SpotOnLive\EntrustDoctrineORM\EntrustDoctrineORMServiceProvider::class,
		Atrauzzi\LaravelDoctrine\ServiceProvider::class,
	    (...)
	]

    'aliases' => [
	    (...)
        'EntityManager' => Atrauzzi\LaravelDoctrine\Support\Facades\Doctrine::class,
        'Entrust' => 'Zizaco\Entrust\EntrustFacade'
	    (...)
	]
```

**User.php**
*Your user entity*
```php
use Doctrine\Common\Collections\ArrayCollection;

class User implements SpotOnLive\EntrustDoctrineORM\Entities\UserRoleInterface
{
    /**
     * @var \SpotOnLive\EntrustDoctrineORM\Entities\RoleInterface[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="SpotOnLive\EntrustDoctrineORM\Entities\Role")
     * @ORM\JoinTable(name="user_role_linker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    protected $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|\SpotOnLive\EntrustDoctrineORM\Entities\RoleInterface[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param ArrayCollection|\SpotOnLive\EntrustDoctrineORM\Entities\RoleInterface[] $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param \SpotOnLive\EntrustDoctrineORM\Entities\RoleInterface[] $roles
     */
    public function addRoles($roles)
    {
        $this->roles->add($roles);
    }

    /**
     * @param \SpotOnLive\EntrustDoctrineORM\Entities\RoleInterface[] $roles
     */
    public function removeRoles($roles)
    {
        $this->roles->remove($roles);
    }

    (...)
}
```

### Migrations

run `$ vendor/bin/doctrine-laravel migrations:diff` and then `$ vendor/bin/doctrine-laravel migrations:migrate`
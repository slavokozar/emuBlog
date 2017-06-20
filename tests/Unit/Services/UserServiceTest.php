<?php

namespace Tests\Unit\Services;

use App\Models\User;
use Facades\App\Services\SportService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data;

    protected function setUp()
    {
        parent::setUp();
        $this->data = [
            'google_id'      => 'asd12312asdasd123123sad',
            'facebook_id'    => 'asd12312asdas123asdasd123123sad',
            'name'           => 'Admin',
            'surname'        => 'Adminko',
            'email'          => 'admin@sportemu.cz',
            'password'       => 'qwerty',
            'remember_token' => 'asd7868769967913123asdasdasdas',
            'phone'          => '+421123123123',
            'iban'           => 'SK987987098323',
            'nickname'       => 'admin',
            'age'            => 123,
            'role'           => 'ADMIN',
            'agreement'      => true,
            'instructor'     => false,
            'gender'         => 'MAN'
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $user = UserService::create($this->data);
        $this->controlProperties($user, $this->data);
        $this->controlUserInDB($user);

        UserService::delete($user);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
            'name' => 'Admin',
        ];

        $result = UserService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $user = UserService::create($this->data);
        $this->controlProperties($user, $this->data);
        $this->controlUserInDB($user);

        $user = UserService::update($user, ['email' => 'emailko@sportemu.cz', 'password' => 'ahahaha']);

        $newData = $this->data;
        $newData['email'] = 'emailko@sportemu.cz';
        $newData['password'] = 'ahahaha';

        $this->controlProperties($user, $newData);
        $this->controlUserInDB($user);

        UserService::delete($user);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $user = UserService::create($this->data);
        $this->controlProperties($user, $this->data);
        $this->controlUserInDB($user);

        $result = UserService::update($user, ['name' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $user = UserService::create($this->data);
        $this->controlProperties($user, $this->data);
        $this->controlUserInDB($user);
        $result = UserService::delete($user);
        self::assertTrue($result);
        $this->controlUserNotInDB($user);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $user = UserService::create($this->data);
        $this->controlProperties($user, $this->data);
        $this->controlUserInDB($user);

        $getUser = UserService::getByID($user->id);
        $this->controlProperties($getUser, $this->data);
        UserService::delete($getUser);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        UserService::getByID(100000);
    }

    /**
     * @return void
     */
    public function testGetByEmail()
    {
        $user = UserService::create($this->data);
        $this->controlProperties($user, $this->data);
        $this->controlUserInDB($user);

        $getUser = UserService::getByEmail($user->email);
        $this->controlProperties($getUser, $this->data);
        UserService::delete($getUser);
    }

    /**
     * @return void
     */
    public function testGetByEmailFail()
    {
        $result = UserService::getByEmail('blablabla@gmail.com');
        self::assertNull($result);
    }

    /**
     * @return void
     */
    public function testIsAdmin()
    {
        $user = UserService::create($this->data);
        $this->controlProperties($user, $this->data);
        $this->controlUserInDB($user);

        self::assertTrue(UserService::isAdmin($user));

        $newData = $this->data;
        $newData['role'] = 'USER';

        $user = UserService::update($user, ['role' => 'USER']);
        $this->controlUserInDB($user);
        $this->controlProperties($user, $newData);
        self::assertFalse(UserService::isAdmin($user));

        UserService::delete($user);
    }


    public function testUserSport()
    {
        $sport = SportService::create([
            'name' => 'football',
        ]);
        $user = UserService::create($this->data);

        $sports = UserService::userSports($user);
        self::assertTrue(count($sports) == 0);

        $user = UserService::addSport($sport, $user, 3);
        $sports = UserService::userSports($user);
        self::assertTrue(count($sports) == 1);
        self::assertTrue($sports->first()->pivot->skill == 3);

        $user = UserService::removeSport($sport, $user);
        $sports = UserService::userSports($user);
        self::assertTrue(count($sports) == 0);

        $user = UserService::addSport($sport, $user, 3);
        SportService::delete($sport);
        $sports = UserService::userSports($user);
        self::assertTrue(count($sports) == 0);
    }

    /**
     *
     */
    public function testPassword()
    {
        $user = UserService::create($this->data);
        self::assertTrue($this->app['hash']->check($this->data['password'], $user->password));
    }

    /**
     * @param User  $user
     * @param array $data
     */
    private function controlProperties($user, $data)
    {
        foreach ($data as $key => $value) {
            if ($key != 'password')
                self::assertTrue($user->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param User $user
     */
    private function controlUserInDB($user)
    {
        $this->assertDatabaseHas('sportemu_users', [
            'google_id'      => $user->google_id,
            'facebook_id'    => $user->facebook_id,
            'name'           => $user->name,
            'surname'        => $user->surname,
            'email'          => $user->email,
            'remember_token' => $user->remember_token,
            'phone'          => $user->phone,
            'iban'           => $user->iban,
            'nickname'       => $user->nickname,
            'age'            => $user->age,
            'role'           => $user->role,
            'agreement'      => $user->agreement,
            'instructor'     => $user->instructor,
            'gender'         => $user->gender,
        ]);
    }

    /**
     * @param User $user
     */
    private function controlUserNotInDB($user)
    {
        $this->assertSoftDeleted('sportemu_users', [
            'google_id'      => $user->google_id,
            'facebook_id'    => $user->facebook_id,
            'name'           => $user->name,
            'surname'        => $user->surname,
            'email'          => $user->email,
            'remember_token' => $user->remember_token,
            'phone'          => $user->phone,
            'iban'           => $user->iban,
            'nickname'       => $user->nickname,
            'age'            => $user->age,
            'role'           => $user->role,
            'agreement'      => $user->agreement,
            'instructor'     => $user->instructor,
            'gender'         => $user->gender,
        ]);
    }

    /**
     * @param string $email
     */
    private function controlEmailNotInDB($email)
    {
        $this->assertDatabaseMissing('sportemu_users', [
            'email' => $email
        ]);
    }
}

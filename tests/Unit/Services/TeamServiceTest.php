<?php

namespace Tests\Unit\Services;

use App\Models\Team;
use Facades\App\Services\TeamService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TeamServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data;

    protected function setUp()
    {
        parent::setUp();
        $this->data = [
            "name"          => 'Test team',
            "meet_info"     => 'Test team info',
            "contact_phone" => '004201231123',
            "iban"          => 'sk213131232131321',
            "cancel_policy" => 'asd as das dsadas das dsadasdasdasd'
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $team = TeamService::create($this->data);
        $this->controlProperties($team, $this->data);
        $this->controlTeamInDB($team);

        TeamService::delete($team);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        $result = TeamService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $team = TeamService::create($this->data);
        $this->controlProperties($team, $this->data);
        $this->controlTeamInDB($team);

        $team = TeamService::update($team, ['name' => 'golf']);

        $newData = $this->data;
        $newData['name'] = 'golf';

        $this->controlProperties($team, $newData);
        $this->controlTeamInDB($team);

        TeamService::delete($team);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $team = TeamService::create($this->data);
        $this->controlProperties($team, $this->data);
        $this->controlTeamInDB($team);

        $result = TeamService::update($team, ['name' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $team = TeamService::create($this->data);
        $this->controlProperties($team, $this->data);
        $this->controlTeamInDB($team);
        $result = TeamService::delete($team);
        self::assertTrue($result);
        $this->controlTeamNotInDB($team);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $team = TeamService::create($this->data);
        $this->controlProperties($team, $this->data);
        $this->controlTeamInDB($team);

        $getTeam = TeamService::getByID($team->id);
        $this->controlProperties($getTeam, $this->data);
        TeamService::delete($getTeam);
    }

    public function testManageUsers()
    {
        $team = TeamService::create($this->data);

        $user = UserService::create([
            'name'      => 'Lukas',
            'surname'   => 'Figura',
            'email'     => 'figura@e-zone.sk',
            'password'  => bcrypt('qwerty'),
            'nickname'  => 'figi',
            'role'      => 'ADMIN',
            'agreement' => true,
            'gender'    => 'MAN'
        ]);

        self::assertTrue(count(TeamService::getUsers($team)) == 0);
        $team = TeamService::addUser($user, $team);
        self::assertTrue(count(TeamService::getUsers($team)) == 1);
        $team = TeamService::addUser($user, $team);
        self::assertTrue(count(TeamService::getUsers($team)) == 1);
        self::assertTrue(count($user->teams) == 1);

        $notAdmin = TeamService::getUsers($team)->first();
        self::assertTrue(count(TeamService::getAdmins($team)) == 0);
        self::assertTrue($notAdmin->pivot->admin == 0);

        $team = TeamService::removeUser($user, $team);
        $user = $user->fresh();
        self::assertTrue(count(TeamService::getUsers($team)) == 0);
        self::assertTrue(count($user->teams) == 0);

        $team = TeamService::addUser($user, $team, true);
        self::assertTrue(count(TeamService::getUsers($team)) == 1);
        self::assertTrue(count(TeamService::getAdmins($team)) == 1);
        $admin = TeamService::getUsers($team)->first();
        self::assertTrue($admin->pivot->admin == 1);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        TeamService::getByID(100000);
    }


    /**
     * @param Team  $team
     * @param array $data
     */
    private function controlProperties($team, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($team->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Team $team
     */
    private function controlTeamInDB($team)
    {
        $this->assertDatabaseHas('sportemu_teams', [
            'name'          => $team->name,
            "meet_info"     => $team->meet_info,
            "contact_phone" => $team->contact_phone,
            "iban"          => $team->iban,
            "cancel_policy" => $team->cancel_policy,
        ]);
    }

    /**
     * @param Team $team
     */
    private function controlTeamNotInDB($team)
    {
        $this->assertSoftDeleted('sportemu_teams', [
            'name'          => $team->name,
            "meet_info"     => $team->meet_info,
            "contact_phone" => $team->contact_phone,
            "iban"          => $team->iban,
            "cancel_policy" => $team->cancel_policy,
        ]);
    }
}

<?php

namespace Tests\Unit\Services;

use App\Models\Notification;
use Facades\App\Services\NotificationService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $user;
    private $data;

    protected function setUp()
    {
        parent::setUp();

        $this->user = UserService::create([
            'name'      => 'Lukas',
            'surname'   => 'Figura',
            'email'     => 'figura@e-zone.sk',
            'password'  => bcrypt('qwerty'),
            'nickname'  => 'figi',
            'role'      => 'ADMIN',
            'agreement' => true,
            'gender'    => 'MAN'
        ]);

        $this->data = [
            'user_id' => $this->user->id,
            'type'    => 1,
            'content' => 'Content asda asd asd sad sa das dasdasd asd sa das',
            'read_at' => null,
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $notification = NotificationService::create($this->data);
        $this->controlProperties($notification, $this->data);
        $this->controlNotificationInDB($notification);

        self::assertTrue($notification->user->id == $this->user->id);

        NotificationService::delete($notification);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        $result = NotificationService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $notification = NotificationService::create($this->data);
        $this->controlProperties($notification, $this->data);
        $this->controlNotificationInDB($notification);

        $notification = NotificationService::update($notification, ['content' => 'shower']);

        $newData = $this->data;
        $newData['content'] = 'shower';

        $this->controlProperties($notification, $newData);
        $this->controlNotificationInDB($notification);

        NotificationService::delete($notification);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $notification = NotificationService::create($this->data);
        $this->controlProperties($notification, $this->data);
        $this->controlNotificationInDB($notification);

        $result = NotificationService::update($notification, ['name' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $notification = NotificationService::create($this->data);
        $this->controlProperties($notification, $this->data);
        $this->controlNotificationInDB($notification);
        $result = NotificationService::delete($notification);
        self::assertTrue($result);
        $this->controlNotificationNotInDB($notification);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $notification = NotificationService::create($this->data);
        $this->controlProperties($notification, $this->data);
        $this->controlNotificationInDB($notification);

        $getNotification = NotificationService::getByID($notification->id);
        $this->controlProperties($getNotification, $this->data);
        NotificationService::delete($getNotification);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        NotificationService::getByID(100000);
    }

    /**
     * @return void
     */
    public function testRead()
    {
        $notification = NotificationService::create($this->data);
        $this->controlProperties($notification, $this->data);
        $this->controlNotificationInDB($notification);

        self::assertFalse(NotificationService::isReaded($notification));

        $result = NotificationService::read($notification);
        self::assertTrue($result);
        $this->controlNotificationInDB($notification);

        self::assertTrue(NotificationService::isReaded($notification));
        NotificationService::delete($notification);
    }


    public function testUserNotifications()
    {
        $notifications = NotificationService::userNotifications($this->user);
        $readedNotifications = NotificationService::userNotifications($this->user, false, true);
        $notReadedNotifications = NotificationService::userNotifications($this->user, true);

        self::assertTrue(count($notifications) == 0);
        self::assertTrue(count($readedNotifications) == 0);
        self::assertTrue(count($notReadedNotifications) == 0);

        $notification = NotificationService::create($this->data);
        $this->controlProperties($notification, $this->data);
        $this->controlNotificationInDB($notification);

        $this->user = $this->user->fresh();

        $notifications = NotificationService::userNotifications($this->user);
        $readedNotifications = NotificationService::userNotifications($this->user, false, true);
        $notReadedNotifications = NotificationService::userNotifications($this->user, true);

        self::assertTrue(count($notifications) == 1);
        self::assertTrue(count($readedNotifications) == 0);
        self::assertTrue(count($notReadedNotifications) == 1);

        NotificationService::read($notification);

        $notifications = NotificationService::userNotifications($this->user);
        $readedNotifications = NotificationService::userNotifications($this->user, false, true);
        $notReadedNotifications = NotificationService::userNotifications($this->user, true);

        self::assertTrue(count($notifications) == 1);
        self::assertTrue(count($readedNotifications) == 1);
        self::assertTrue(count($notReadedNotifications) == 0);

        NotificationService::delete($notification);

        $this->user = $this->user->fresh();

        $notifications = NotificationService::userNotifications($this->user);
        $readedNotifications = NotificationService::userNotifications($this->user, false, true);
        $notReadedNotifications = NotificationService::userNotifications($this->user, true);

        self::assertTrue(count($notifications) == 0);
        self::assertTrue(count($readedNotifications) == 0);
        self::assertTrue(count($notReadedNotifications) == 0);
    }

    /**
     * @param Notification $notification
     * @param array        $data
     */
    private function controlProperties($notification, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($notification->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Notification $notification
     */
    private function controlNotificationInDB($notification)
    {
        $this->assertDatabaseHas('sportemu_notifications', [
            'content' => $notification->content,
            'type'    => $notification->type,
            'user_id' => $notification->user_id,
            'read_at' => $notification->read_at,
        ]);
    }

    /**
     * @param Notification $notification
     */
    private function controlNotificationNotInDB($notification)
    {
        $this->assertSoftDeleted('sportemu_notifications', [
            'content' => $notification->content,
            'type'    => $notification->type,
            'user_id' => $notification->user_id,
            'read_at' => $notification->read_at,
        ]);
    }
}

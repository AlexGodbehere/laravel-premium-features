<?php
declare(strict_types=1);

namespace AlexGodbehere\Tests;

use AlexGodbehere\Tests\Model\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Domain\TestDomain\Features\TestFeature;

/**
 * Class AchievementTest
 *
 * @package Assada\Tests
 */
class FeatureTest extends DBTestCase
{

    public $users;

    public $onePost;

    public $tenPosts;

    public function setUp()
    : void
    {

        parent::setUp();
        $this->users[] = User::find(1);
        $this->users[] = User::find(2);
        $this->users[] = User::find(3);
        $this->users[] = User::find(4);
        $this->users[] = User::find(5);
    }

    /**
     * Tests the setup
     */
    public function testSetup()
    {

        // For users, check only names.
        // Achiever classes don't matter much. They just need to exist and have IDs.
        $this->assertEquals($this->users[0]->name, 'Gamer0');
        $this->assertEquals($this->users[1]->name, 'Gamer1');
        $this->assertEquals($this->users[2]->name, 'Gamer2');
        $this->assertEquals($this->users[3]->name, 'Gamer3');
        $this->assertEquals($this->users[4]->name, 'Gamer4');
    }

    /**
     * Tests unlocking features.
     */
    public function testCreateFeature()
    {

        $this->artisan('make:feature TestFeature TestDomain TestFeature TestDescription CancelText CheckString')->run();
        $this->assertDatabaseHas('features', [
          'name'           => 'TestFeature',
          'description'    => 'TestDescription',
          'cancel_warning' => 'CancelText',
          'check_string'   => 'CheckString',
          'class_name'     => TestFeature::class,

        ]);
    }

}

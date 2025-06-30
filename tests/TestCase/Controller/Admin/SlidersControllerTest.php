<?php
declare(strict_types=1);

namespace Slideshow\Test\TestCase\Controller\Admin;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Slideshow\Controller\Admin\SlidersController Test Case
 *
 * @uses \Slideshow\Controller\Admin\SlidersController
 */
class SlidersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Roles',
        'plugin.Slideshow.Sliders',
    ];

    /**
     * setUp method
     *
     * This method is called before each test method.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $user = $this->fetchTable('Users')->get(1);

        $this->session([
            'Auth' => [
                'User' => $user,
            ],
        ]);
    }

    /**
     * tearDown method
     *
     * This method is called after each test method.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \Slideshow\Controller\Admin\SlidersController::index()
     */
    public function testIndex(): void
    {
        $this->get('/admin/slideshow/sliders');

        $this->assertResponseOk();
        $this->assertNotNull($this->viewVariable('sliders'));
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \Slideshow\Controller\Admin\SlidersController::view()
     */
    public function testView(): void
    {
        $this->get('/admin/slideshow/sliders/view/1');
        $this->assertResponseOk();

        $this->assertNotEmpty($this->viewVariable('slider'));
        $this->assertEquals(1, $this->viewVariable('slider')->id);
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \Slideshow\Controller\Admin\SlidersController::add()
     */
    public function testAddGet(): void
    {
        $this->get('/admin/slideshow/sliders/add');
        $this->assertResponseOk();
    }

    /**
     * Test add post method
     *
     * @return void
     * @uses \Slideshow\Controller\Admin\SlidersController::add()
     */
    public function testAddPost(): void
    {
        $postData = [
            'title' => 'Test Slider',
            'description' => 'This is a test slider description.',
            'width' => 800,
            'height' => 600,
            'delay' => 5000,
        ];
        $this->post('/admin/slideshow/sliders/add', $postData);
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/admin/slideshow/sliders');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \Slideshow\Controller\Admin\SlidersController::edit()
     */
    public function testEditGet(): void
    {
        $this->get('/admin/slideshow/sliders/edit/1');
        $this->assertResponseOk();
    }

    /**
     * Test edit post method
     *
     * @return void
     * @uses \Slideshow\Controller\Admin\SlidersController::edit()
     */
    public function testEditPost(): void
    {
        $postData = [
            'title' => 'Updated Slider',
            'description' => 'This is an updated slider description.',
            'width' => 1024,
            'height' => 768,
            'delay' => 3000,
        ];
        $this->post('/admin/slideshow/sliders/edit/1', $postData);
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/admin/slideshow/sliders');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \Slideshow\Controller\Admin\SlidersController::delete()
     */
    public function testDeletePost(): void
    {
        $this->post('/admin/slideshow/sliders/delete/1');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/admin/slideshow/sliders');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: brightantwiboasiako
 * Date: 2/11/20
 * Time: 4:20 PM
 */

namespace Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    /**
     * @var Factory
     */
    protected $faker;

    /**
     * BaseTest constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
        parent::__construct();
    }


}
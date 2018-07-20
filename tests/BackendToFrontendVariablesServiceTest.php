<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Tests;

use DateTime;
use Tarampampam\Wrappers\Json;
use AvtoDev\BackendToFrontendVariablesStack\Service\BackendToFrontendVariablesStack;
use AvtoDev\BackendToFrontendVariablesStack\Contracts\BackendToFrontendVariablesInterface;

/**
 * Test service for transferring data from the back to the front.
 *
 * @coversDefaultClass \AvtoDev\BackendToFrontendVariablesStack\Service\BackendToFrontendVariablesStack
 *
 * @group back-to-front
 */
class BackendToFrontendVariablesServiceTest extends AbstractTestCase
{
    /**
     * @var BackendToFrontendVariablesStack
     */
    protected $service;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->service = $this->getService();
    }

    /**
     * The toArray method. An array of deep nesting.
     *
     * @covers ::toScalarsRecursive
     * @covers ::toArray
     */
    public function testToArrayDeepScalar()
    {
        $deep_array               = [];
        $test_deep_array_scalar   = str_random();
        $test_deep_array_key_path = '0.test.1.4.A.#test.88';

        array_set($deep_array, $test_deep_array_key_path, $test_deep_array_scalar);

        $this->service->put('test_deep', $deep_array);

        $result = $this->service->toArray();

        $this->assertEquals($test_deep_array_scalar, array_get($result, 'test_deep.' . $test_deep_array_key_path));
    }

    /**
     * The toArray method. An object that can not be converted to an array.
     *
     * @covers ::clearNoScalarsFromArrayRecursive
     * @covers ::toArray
     */
    public function testToArrayStdObject()
    {
        $this->service->put('test_obj', new \stdClass);

        $result = $this->service->toArray();

        $this->assertNull(array_get($result, 'test_obj'));
    }

    /**
     * The toArray method. Format the date and time.
     *
     * @covers ::toScalarsRecursive
     * @covers ::toArray
     */
    public function testToArrayDateTime()
    {
        $date_format = 'Y-m-d H:i:s';

        $date_time    = new DateTime('1997-08-29');

        $this->service->put('date_time', $date_time);

        $result = $this->service->toArray();

        $this->assertEquals($date_time->format($date_format), $result['date_time']);
    }

    /**
     * The toArray method. An array of deep nesting. An object that can not be converted to an array.
     *
     * @covers ::toArray
     * @covers ::toScalarsRecursive
     * @covers ::clearNoScalarsFromArrayRecursive
     */
    public function testToArrayDeepStdObject()
    {
        $deep_array               = [];
        $test_deep_array_object   = new \stdClass;
        $test_deep_array_key_path = '0.test.1.4.A.#test.88';

        array_set($deep_array, $test_deep_array_key_path, $test_deep_array_object);

        $this->service->put('test_deep', $deep_array);

        $result = $this->service->toArray();

        $this->assertNull(array_get($result, 'test_deep.' . $test_deep_array_key_path));
    }

    /**
     * Adding data to the stack and output to json.
     *
     * @covers ::put
     * @covers ::get
     * @covers ::toJson
     */
    public function testPutGetToJson()
    {
        $test_data[]             = [str_random(), random_int(0, 100)];
        $test_data[]             = random_int(-10, 10);
        $test_data[]             = null;
        $test_data[str_random()] = str_random();
        $test_data[-10]          = str_random();
        $test_data['collection'] = collect([1]);

        foreach ($test_data as $key => $value) {
            $this->service->put($key, $value);
        }

        $in_array = $this->service->toArray();

        $parsed_data = Json::decode($this->service->toJson(), true);

        // Verifying that the array received through toArray contains the same data that was returned to toJson
        $this->assertEquals($in_array, $parsed_data);

        foreach ($test_data as $key => $value) {
            // Getting raw data
            $this->assertEquals($value, $this->service->get($key));

            // Checking data after conversion to JSON
            if (is_scalar($value)) {
                $this->assertEquals($value, $parsed_data[$key]);
            } else {
                $this->assertEquals(Json::decode(Json::encode($value), true), $parsed_data[$key]);
            }
        }
    }

    /**
     * Checking the has method.
     *
     * @covers ::has
     */
    public function testHas()
    {
        $test_key = str_random();

        $this->service->put($test_key, 1);

        $this->assertTrue($this->service->has($test_key));
        $this->assertFalse($this->service->has(str_random()));
    }

    /**
     * Checking the forget method.
     *
     * @covers ::forget
     */
    public function testForget()
    {
        $test_key = str_random();

        $this->service->put($test_key, 1);

        $this->assertTrue($this->service->has($test_key));

        $this->service->forget($test_key);

        $this->assertFalse($this->service->has($test_key));
    }

    /**
     * {@inheritdoc}
     */
    protected function getService()
    {
        return $this->app->make(BackendToFrontendVariablesInterface::class);
    }
}

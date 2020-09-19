<?php

namespace Tests\Unit;

use App\Http\Requests\UnitTestRequest;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Validator;

class ImportTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        // $this->assertTrue(true);

        //** this is simple test, we can make array of objects and
        // skip object not valid then create valid data */

        $user = [
            'first_name' => 'test',
            'second_name' => 'test',
            'family_name' => 'parent',
            'uid' => '8383883773'
        ];

        $this->assertFalse(
            array_search(null, $user) || array_search('', $user)
        );
    }

    /**
     * @dataProvider provideValidData
     */
    // public function testValidData(array $data)
    // {
    //     $data = [
    //         'first_name' => 'test',
    //         'second_name' => 'test',
    //         'family_name' => 'parent',
    //         'uid' => '8383883773'
    //     ];
    //     $request = new UnitTestRequest();

    //     $validator = Validator::make($data, $request->rules());

    //     $this->assertTrue($validator->passes());

    //     $this->assertFalse($validator->fails());
    // }

}

<?php

namespace Tests\Unit\Client\JobContent\Forms;

use Illuminate\Validation\Validator;
use Tests\TestCase;

class JobContentStoreRequestTest extends TestCase
{
    /**
     * @return void
     * @see JobContentStoreRequest
     */
    public function testJobContentText()
    {
        // required passes
        $validator = $this->formFieldValidator('job_content_text', str_repeat('あ', 5));
        $this->assertTrue($validator->passes());

        // required failed
        $validator = $this->formFieldValidator('job_content_text', null);
        $this->assertFalse($validator->passes());

        // max:1000 passes
        $validator = $this->formFieldValidator('job_content_text', str_repeat('あ', 1000));
        $this->assertTrue($validator->passes());

        // max:1000 failed
        $validator = $this->formFieldValidator('job_content_text', str_repeat('あ', 1001));
        $this->assertFalse($validator->passes());
    }

    /**
     * @return void
     * @see JobContentStoreRequest
     */
    public function testJobContentNotice()
    {
        // max:1000 passes
        $validator = $this->formFieldValidator('job_content_notice', str_repeat('あ', 1000));
        $this->assertTrue($validator->passes());

        // max:1000 failed
        $validator = $this->formFieldValidator('job_content_notice', str_repeat('あ', 1001));
        $this->assertFalse($validator->passes());
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return Validator
     */
    private function formFieldValidator(string $key, mixed $value): Validator
    {
        $request = new JobContentStoreRequest();
        return validator([$key => $value], [$key => $request->rules()[$key]],);
    }
}

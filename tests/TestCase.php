<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

    /**
     * @param string $registerClass Class Name to register as.
     * @param string $class Name of the class to mock.
     * @param array $methods Method names to mock
     * @return \Mockery\MockInterface
     */
    public function createMock($registerClass, $class, array $methods = [])
    {
        if (count($methods) > 0) {
            $class .= '[' . join(',', $methods) .']';
        }
        $mock = Mockery::mock($class);

        $this->app->instance($registerClass, $mock);

        return $mock;
    }

    /**
     * @param string $class Model Class to create a mock for.
     * @return \Mockery\MockInterface
     */
    public function createMockModel($class)
    {
        $mock = Mockery::mock('Illuminate\Database\Eloquent\Model, ' . $class);

        $this->app->instance($class, $mock);

        return $mock;
    }
}

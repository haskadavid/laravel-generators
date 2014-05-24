<?php namespace Haska\Generators;

use Illuminate\Support\ServiceProvider;
use Haska\Generators\Commands\ControllerGeneratorCommand;
use Haska\Generators\Commands\ModelGeneratorCommand;
use Haska\Generators\Commands\ResourceGeneratorCommand;
use Haska\Generators\Commands\SeederGeneratorCommand;
use Haska\Generators\Commands\PublishTemplatesCommand;
use Haska\Generators\Commands\ScaffoldGeneratorCommand;
use Haska\Generators\Commands\ViewGeneratorCommand;
use Haska\Generators\Commands\PivotGeneratorCommand;

class GeneratorsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


    /**
     * Booting
     */
    public function boot()
    {
        $this->package('haska/laravel-generators');
    }

	/**
	 * Register the commands
	 *
	 * @return void
	 */
	public function register()
	{
        foreach([
            'Model',
            'View',
            'Controller',
            'Migration',
            'Seeder',
            'Pivot',
            'Resource',
            'Scaffold',
            'Publisher'] as $command)
        {
            $this->{"register$command"}();
        }
	}

    /**
     * Register the model generator
     */
    protected function registerModel()
    {
        $this->app['generate.model'] = $this->app->share(function($app)
        {
            $generator = $this->app->make('Haska\Generators\Generator');

            return new ModelGeneratorCommand($generator);
        });

        $this->commands('generate.model');
    }

    /**
     * Register the view generator
     */
    protected function registerView()
    {
        $this->app['generate.view'] = $this->app->share(function($app)
        {
            $generator = $this->app->make('Haska\Generators\Generator');

            return new ViewGeneratorCommand($generator);
        });

        $this->commands('generate.view');
    }

    /**
     * Register the controller generator
     */
    protected function registerController()
    {
        $this->app['generate.controller'] = $this->app->share(function($app)
        {
            $generator = $this->app->make('Haska\Generators\Generator');

            return new ControllerGeneratorCommand($generator);
        });

        $this->commands('generate.controller');
    }

    /**
     * Register the migration generator
     */
    protected function registerMigration()
    {
        $this->app['generate.migration'] = $this->app->share(function($app)
        {
            return $this->app->make('Haska\Generators\Commands\MigrationGeneratorCommand');
        });

        $this->commands('generate.migration');
    }

    /**
     * Register the seeder generator
     */
    protected function registerSeeder()
    {
        $this->app['generate.seeder'] = $this->app->share(function($app)
        {
            $generator = $this->app->make('Haska\Generators\Generator');

            return new SeederGeneratorCommand($generator);
        });

        $this->commands('generate.seeder');
    }

    /**
     * Register the pivot generator
     */
    protected function registerPivot()
    {
        $this->app['generate.pivot'] = $this->app->share(function($app)
        {
            return new PivotGeneratorCommand;
        });

        $this->commands('generate.pivot');
    }

    /**
     * Register the resource generator
     */
    protected function registerResource()
    {
        $this->app['generate.resource'] = $this->app->share(function($app)
        {
            $generator = $this->app->make('Haska\Generators\Generator');

            return new ResourceGeneratorCommand($generator);
        });

        $this->commands('generate.resource');
    }

    /**
     * register command for publish templates
     */
    public function registerpublisher()
    {
        $this->app['generate.publish-templates'] = $this->app->share(function($app)
        {
            return new publishtemplatescommand;
        });

        $this->commands('generate.publish-templates');
    }

    /**
     * register scaffold command
     */
    public function registerScaffold()
    {
        $this->app['generate.scaffold'] = $this->app->share(function($app)
        {
            return new ScaffoldGeneratorCommand;
        });

        $this->commands('generate.scaffold');
    }



	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}

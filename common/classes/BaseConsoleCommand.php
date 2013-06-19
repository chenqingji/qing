<?php
/**
 * 后台程序控制类基本类
 * 
 * @author Administrator
 */
class BaseConsoleCommand extends CConsoleCommand {

	/**
	 * Executes the command.
	 * The default implementation will parse the input parameters and
	 * dispatch the command request to an appropriate action with the
	 * corresponding
	 * option values
	 * 
	 * @param $args array command line parameters for this command.
	 */
	public function run($args) {
		list ( $action, $options, $args ) = $this->resolveRequest( $args );
		$methodName = $action;
		if (! preg_match( '/^\w+$/', $action ) || ! method_exists( $this, $methodName ))
			$this->usageError( "Unknown action: " . $action );
		
		$method = new ReflectionMethod( $this, $methodName );
		$params = array ();
		// named and unnamed options
		foreach ( $method->getParameters() as $i => $param ) {
			$name = $param->getName();
			if (isset( $options [$name] )) {
				if ($param->isArray())
					$params [] = is_array( $options [$name] ) ? $options [$name] : array ($options [$name] );
				else if (! is_array( $options [$name] ))
					$params [] = $options [$name];
				else
					$this->usageError( "Option --$name requires a scalar. Array is given." );
			} else if ($name === 'args')
				$params [] = $args;
			else if ($param->isDefaultValueAvailable())
				$params [] = $param->getDefaultValue();
			else
				$this->usageError( "Missing required option --$name." );
			unset( $options [$name] );
		}
		
		// try global options
		if (! empty( $options )) {
			$class = new ReflectionClass( get_class( $this ) );
			foreach ( $options as $name => $value ) {
				if ($class->hasProperty( $name )) {
					$property = $class->getProperty( $name );
					if ($property->isPublic() && ! $property->isStatic()) {
						$this->$name = $value;
						unset( $options [$name] );
					}
				}
			}
		}
		
		if (! empty( $options ))
			$this->usageError( "Unknown options: " . implode( ', ', array_keys( $options ) ) );
		
		if ($this->beforeAction( $action, $params )) {
			$method->invokeArgs( $this, $params );
			$this->afterAction( $action, $params );
		}
	}
}

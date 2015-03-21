<?php
namespace Pennline\Config;

use Pennline\Php\Exception;

class Config {

	/**
	 * number of elements in configuration data.
	 *
	 * @var int
	 */
	protected $count;

	/**
	 * data within the configuration.
	 *
	 * @var array
	 */
	protected $data;


	/**
	 * @param array $properties
	 */
	public function __construct( $properties = array() ) {
		$this->init();
		$this->populate( $properties );
	}

	/**
	 * magic function so that Config->value will work.
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get( $name ) {
    return $this->get( $name );
  }

	/**
	* needed when testing a property with isset() or empty()
	* on a class property that’s retrieved using __get()
	*
	* @param  string $name
	* @return bool
	*/
	public function __isset( $name ) {
		return isset( $this->data[$name] );
	}

	public function __toString() {
		return '';
	}

	/**
	 * retrieve a value and return $default if there is no element set.
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function get( $name, $default = null ) {
		if ( array_key_exists( $name, $this->data ) ) {
			return $this->data[$name];
		}

		return $default;
	}

	protected function init() {
		$this->count = 0;
		$this->data = array();
	}

	/**
	 * @param array $properties
	 * @throws Exception
	 */
	protected function populate( $properties = array() ) {
		if ( !is_array( $properties ) ) {
			error_log( __METHOD__ . '() $properties provided are not an array' );
			throw new Exception( 'parameter type error', 1 );
		}

		foreach ( $properties as $key => $value ) {
			if ( is_array( $value ) ) {
				$this->data[$key] = new static( $value );
			} else {
				$this->data[$key] = $value;
			}

			$this->count += 1;
		}
	}

}
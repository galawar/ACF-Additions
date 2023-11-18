<?php

namespace ACFAdditions;

trait Singleton
{
	protected static $instance;

	final public static function getInstance()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new static();
		}
		return self::$instance;
	}

	final public static function destroy()
	{
		static::$instance = null;
	}

	private function __construct()
	{
		$this->init();
	}

	protected function init()
	{
	}

}
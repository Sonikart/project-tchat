<?php

	class configuration
	{
		public $bdd;
		function __construct()
		{
			include 'mysql.php';
			try
			{
				$this->bdd = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'], $config['user'], $config['pass'], array(1002 => 'SET NAMES utf8'));
			}

			catch (PDOException $e)
			{
				echo $e->getMessage();
			}
		}

		function count($var)
		{
			$query = $this->bdd->query('SELECT COUNT(*) as count FROM '.$var);
			$fetch = $query->fetch();
			return $fetch['count'];
		}

		function get_config($var)
		{
			$query = $this->bdd->query('SELECT * FROM configuration');
			$fetch = $query->fetch();

			return $fetch[$var];
		}

		function rank($var)
		{
			if($var == 1)
			{
				return 'User';
			}

			if($var == 2)
			{
				return 'Administrator';
			}
		}

		function plan($var)
		{
			if($var == 0)
			{
				return 'NO OFFER';
			}

			if($var == 1)
			{
				return 'FREE';
			}

			if($var == 2)
			{
				return 'PREMIUM';
			}
		}

		function security($var)
		{
			return htmlspecialchars($var);
		}

		function format_page()
		{
			$explode = explode('.', $_SERVER['PHP_SELF']);
			return ucfirst(substr($explode[0], 1));
		}

		function date($timestamp, $config)
		{
			if($config == 'all')
			{
				return date('H:i j/m/Y', $timestamp);
			}

			if($config == 'date')
			{
				return date('j/m/Y', $timestamp);
			}

			if($config == 'hour')
			{
				return date('H:i', $timestamp);
			}
		}

	}

?>
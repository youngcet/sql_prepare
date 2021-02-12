<?php

	include ("db.php");

	class DBHandler extends Database
	{
		private $_dbconn;
		private $_stmt;
		private $_results;
		private $_error;

		public function __construct()
		{
			$this->_dbconn = $this->connect();
			$this->_stmt = (object) array ();
			$this->_error = $this->_results = array ();
		}

		protected function isConnected (): object
		{
			return $this->_dbconn;
		}

		protected function prepareStatement ($sqlStatement): bool
		{
			if (! $this->isConnected() || ! $this->_stmt = $this->_dbconn->prepare ($sqlStatement))
			{
				$this->_error['error'] = $this->_dbconn->connect_error;
				return 0;
			}

			return 1;
		}

		protected function executeStatement ($values, $valueType): bool
		{
			$this->_stmt->bind_param ($valueType, ...$values);
			if (! $this->isConnected() || ! $this->_stmt->execute())
			{
				$this->_error['error'] = $this->_dbconn->connect_error;
				return 0;
			}

			$this->_results = $this->_stmt->get_result();
			$this->_stmt->close();

			return 1;

		}

		protected function fetchAll (): array
		{
			if ($this->_results->num_rows === 0)
			{
				return array();
			}

			return $this->_results->fetch_assoc();
		}

		protected function getError(): array
		{
			return $this->_error;
		}

		protected function closeConnection(): void
		{
			if ($this->isConnected ())
			{
				$this->_dbconn->close();
			}
		}
	}
?>
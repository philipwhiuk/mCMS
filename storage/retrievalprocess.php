<?php
/**
 * Interface representing a retrieval process.
 */
interface Storage_RetrievalProcess {
    /**
	 * Indicates the results should be ordered by the given columns
	 */
	function order($cols);
	/**
	 * Indicates, at most, the specified number of results should be returned.
	 */
	function limit($number);
}
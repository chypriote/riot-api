<?php

/**
 * Copyright (C) 2016-2018  Daniel Dolejška
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

use RiotAPI\RiotAPI;
use RiotAPI\Objects;
use RiotAPI\Definitions\Region;


class ChampionEndpointTest extends RiotAPITestCase
{
	public function testInit()
	{
		$api = new RiotAPI([
			RiotAPI::SET_KEY             => getenv('API_KEY'),
			RiotAPI::SET_REGION          => Region::EUROPE_EAST,
			RiotAPI::SET_USE_DUMMY_DATA  => true,
			RiotAPI::SET_CACHE_RATELIMIT => true,
		]);

		$this->assertInstanceOf(RiotAPI::class, $api);

		return $api;
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetChampionRotations( RiotAPI $api )
	{
		//  Get library processed results
		/** @var Objects\ChampionInfo $result */
		$result = $api->getChampionRotations();

		$this->assertEquals([16, 45, 50, 62, 64, 78, 89, 90, 127, 131, 154, 203, 222, 223], $result->freeChampionIds);
		$this->assertEquals([18, 81, 92, 141, 37, 238, 19, 45, 25, 64], $result->freeChampionIdsForNewPlayers);
		$this->assertEquals(10, $result->maxNewPlayerLevel);
	}
}

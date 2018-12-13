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
use RiotAPI\Objects\StaticData;
use RiotAPI\Definitions\Region;


class StaticDataEndpointTest extends RiotAPITestCase
{
	public function testInit()
	{
		$api = new RiotAPI([
			RiotAPI::SET_KEY             => getenv('API_KEY'),
			RiotAPI::SET_REGION          => Region::EUROPE_EAST,
			RiotAPI::SET_USE_DUMMY_DATA  => true,
			RiotAPI::SET_DATADRAGON_INIT => true,
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
	public function testGetStaticChampions_ById( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticChampionListDto $result */
		$result = $api->getStaticChampions();

		$this->assertSameSize($api->getResult()['data'], $result->data);
		$this->assertSame(array_keys($result->data), array_values($result->keys));

		$this->assertArrayHasKey("Orianna", $result->data);
		$this->assertSame("Orianna", $result->data["Orianna"]->id);
		$this->assertSame("61", $result->data["Orianna"]->key);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticChampions_ByKey( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticChampionListDto $result */
		$result = $api->getStaticChampions(true);

		$this->assertSameSize($api->getResult()['data'], $result->data);
		$this->assertSame(array_keys($result->data), array_values($result->keys));

		$this->assertArrayHasKey(61, $result->data);
		$this->assertSame("Orianna", $result->data[61]->id);
		$this->assertSame("61", $result->data[61]->key);
		$this->assertArrayNotHasKey('skins', $api->getResult()['data'][61]);
		$this->assertArrayNotHasKey('spells', $api->getResult()['data'][61]);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticChampion( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticChampionDto $result */
		$result = $api->getStaticChampion(61);

		$this->assertSame("Orianna", $result->id);
		$this->assertSame("61", $result->key);
		$this->assertSame("the Lady of Clockwork", $result->title);
		$this->assertArrayNotHasKey('skins', $api->getResult());
		$this->assertNull($result->skins);
		$this->assertArrayNotHasKey('spells', $api->getResult());
		$this->assertNull($result->spells);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticChampion_extended( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticChampionDto $result */
		$result = $api->getStaticChampion(61, true);

		$this->assertSame("Orianna", $result->id);
		$this->assertSame("61", $result->key);
		$this->assertSame("the Lady of Clockwork", $result->title);
		$this->assertSameSize($api->getResult()['skins'], $result->skins);
		$this->assertSameSize($api->getResult()['spells'], $result->spells);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticItems_ItemListData( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticItemListDto $result */
		$result = $api->getStaticItems();

		$this->assertSameSize($api->getResult()['data'], $result->data);

		$this->assertArrayHasKey(3089, $result->data);
		$this->assertSame("Rabadon's Deathcap", $result->data[3089]->name);
		$this->assertSame(3089, $result->data[3089]->id);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticItem_ItemListData( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticItemDto $result */
		$result = $api->getStaticItem(3089); //  RABADON YAY

		$this->assertSame("Rabadon's Deathcap", $result->name);
		$this->assertSame(3089, $result->id);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticLanguageStrings( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticLanguageStringsDto $result */
		$result = $api->getStaticLanguageStrings('cs_CZ', null);

		$this->assertSameSize($api->getResult()['data'], $result->data);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticLanguages( RiotAPI $api )
	{
		//  Get library processed results
		/** @var array $result */
		$result = $api->getStaticLanguages();

		$this->assertSame($api->getResult(), $result);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticMaps( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticMapDataDto $result */
		$result = $api->getStaticMaps();

		$this->assertSameSize($api->getResult()['data'], $result->data);
		$this->assertArrayHasKey(10, $result->data, "Twisted Treeline map not found.");
		$this->assertArrayHasKey(11, $result->data, "Summoner's Rift map not found.");
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticMasteries_MasteryListData( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticMasteryListDto $result */
		$result = $api->getStaticMasteries('en_US', "6.24.1");

		$this->assertSameSize($api->getResult()['data'], $result->data);

		$this->assertArrayHasKey(6362, $result->data);
		$this->assertSame("Thunderlord's Decree", $result->data[6362]->name);
		$this->assertSame(6362, $result->data[6362]->id);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticMastery_MasteryListData( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticMasteryDto $result */
		$result = $api->getStaticMastery(6362, 'en_US', "6.24.1"); //  THE LORD OF THUNDER

		$this->assertSame("Thunderlord's Decree", $result->name);
		$this->assertSame(6362, $result->id);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticRealm( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticRealmDto $result */
		$result = $api->getStaticRealm();

		$this->assertSame($api->getResult()['n'], $result->n);
	}


	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticReforgedRunePaths( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticReforgedRunePathDto[] $result */
		$result = $api->getStaticReforgedRunePaths();

		$this->assertSameSize($api->getResult(), $result);

		$this->assertArrayHasKey(8200, $result);
		$this->assertSame(8200, $result[8200]->id);
		$this->assertSame("Sorcery", $result[8200]->key);
		$this->assertSame("Sorcery", $result[8200]->name);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticReforgedRunes( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticReforgedRuneDto[] $result */
		$result = $api->getStaticReforgedRunes();

		$this->assertSame(8229, $result[8229]->id);
		$this->assertSame("ArcaneComet", $result[8229]->key);
		$this->assertSame("Arcane Comet", $result[8229]->name);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticRunes_RuneListData( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticRuneListDto $result */
		$result = $api->getStaticRunes('en_US', "6.24.1");

		$this->assertSameSize($api->getResult()['data'], $result->data);

		$this->assertArrayHasKey(5357, $result->data);
		$this->assertSame("Greater Quintessence of Ability Power", $result->data[5357]->name);
		//$this->assertSame(5357, $result->data[5357]->id);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticRune_RuneListData( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticRuneDto $result */
		$result = $api->getStaticRune(5357, 'en_US', "6.24.1"); //  GIMME MOAR AP

		$this->assertSame("Greater Quintessence of Ability Power", $result->name);
		//$this->assertSame(5357, $result->id);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticSummonerSpells_ById( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticSummonerSpellListDto $result */
		$result = $api->getStaticSummonerSpells();

		$this->assertArrayHasKey('SummonerExhaust', $result->data);
		$this->assertSame('Exhaust', $result->data['SummonerExhaust']->name);
		$this->assertSame('SummonerExhaust', $result->data['SummonerExhaust']->id);
		$this->assertSame('3', $result->data['SummonerExhaust']->key);
		$this->assertSame('Exhausts target enemy champion, reducing their Movement Speed by 30%, and their damage dealt by 40% for 2.5 seconds.', $result->data['SummonerExhaust']->description);

		$this->assertArrayHasKey('SummonerFlash', $result->data);
		$this->assertSame('Flash', $result->data['SummonerFlash']->name);
		$this->assertSame('SummonerFlash', $result->data['SummonerFlash']->id);
		$this->assertSame('4', $result->data['SummonerFlash']->key);
		$this->assertSame('Teleports your champion a short distance toward your cursor\'s location.', $result->data['SummonerFlash']->description);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticSummonerSpells_ByKey( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticSummonerSpellListDto $result */
		$result = $api->getStaticSummonerSpells(true);

		$this->assertSame('Exhaust', $result->data[3]->name);
		$this->assertSame('SummonerExhaust', $result->data[3]->id);
		$this->assertSame('3', $result->data[3]->key);
		$this->assertSame('Exhausts target enemy champion, reducing their Movement Speed by 30%, and their damage dealt by 40% for 2.5 seconds.', $result->data[3]->description);

		$this->assertSame('Flash', $result->data[4]->name);
		$this->assertSame('SummonerFlash', $result->data[4]->id);
		$this->assertSame('4', $result->data[4]->key);
		$this->assertSame('Teleports your champion a short distance toward your cursor\'s location.', $result->data[4]->description);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticSummonerSpell_SpellListData( RiotAPI $api )
	{
		//  Get library processed results
		/** @var StaticData\StaticSummonerSpellDto $result */
		$result = $api->getStaticSummonerSpell(4); //  JUST IN CASE?

		$this->assertSame('Flash', $result->name);
		$this->assertSame('SummonerFlash', $result->id);
		$this->assertSame('4', $result->key);
		$this->assertSame('Teleports your champion a short distance toward your cursor\'s location.', $result->description);
	}

	/**
	 * @depends testInit
	 *
	 * @param RiotAPI $api
	 */
	public function testGetStaticVersions( RiotAPI $api )
	{
		//  Get library processed results
		/** @var array $result */
		$result = $api->getStaticVersions();

		$this->assertSame($api->getResult(), $result);
	}
}

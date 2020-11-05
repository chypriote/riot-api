<?php

/**
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

namespace RiotAPI\LeagueAPI\Objects;


/**
 *   Class LoRPlayerDto
 *
 * Used in:
 *   lor-match (v1)
 *     @link https://developer.riotgames.com/apis#lor-match-v1/GET_getMatch
 *
 * @package RiotAPI\LeagueAPI\Objects
 */
class LoRPlayerDto extends ApiObject
{
    /** @var string $puuid */
    public $puuid;

    /** @var string $deck_id */
    public $deck_id;

    /**
     * Code for the deck played. Refer to LOR documentation for details on deck codes.
     *
     * @var string $deck_code
     */
    public $deck_code;

    /** @var string[] $factions */
    public $factions;

    /** @var string $game_outcome */
    public $game_outcome;

    /**
     * The order in which the players took turns.
     *
     * @var string $order_of_play
     */
    public $order_of_play;
}

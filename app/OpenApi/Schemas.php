<?php

/**
 * @OA\Schema(
 *     schema="Article",
 *     required={"id", "title", "content", "published_at", "source_id", "category_id"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="author", type="string", nullable=true),
 *     @OA\Property(property="published_at", type="string", format="date-time"),
 *     @OA\Property(property="source_id", type="integer"),
 *     @OA\Property(property="category_id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * @OA\Schema(
 *     schema="ArticleRequest",
 *     required={"title", "content", "published_at", "source_id", "category_id"},
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="author", type="string", nullable=true),
 *     @OA\Property(property="published_at", type="string", format="date-time"),
 *     @OA\Property(property="source_id", type="integer"),
 *     @OA\Property(property="category_id", type="integer")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UserPreference",
 *     required={"id", "user_id", "source_id", "category_id"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="source_id", type="integer"),
 *     @OA\Property(property="category_id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="source",
 *         ref="#/components/schemas/Source"
 *     ),
 *     @OA\Property(
 *         property="category",
 *         ref="#/components/schemas/Category"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="UserPreferenceRequest",
 *     required={"source_id", "category_id"},
 *     @OA\Property(property="source_id", type="integer"),
 *     @OA\Property(property="category_id", type="integer")
 * )
 */

/**
 * @OA\Schema(
 *     schema="Source",
 *     required={"id", "name", "url"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="url", type="string")
 * )
 */

/**
 * @OA\Schema(
 *     schema="Category",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string")
 * )
 */

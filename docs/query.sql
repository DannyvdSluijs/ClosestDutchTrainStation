SELECT 
    id, 
    name,
    ( 6371 * acos( cos( radians(52.1233468) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(5.1826655) ) + sin( radians(52.1233468) ) * sin( radians( latitude ) ) ) ) AS distance 
FROM TrainStation 
HAVING distance < 25 
ORDER BY distance LIMIT 0 , 20;

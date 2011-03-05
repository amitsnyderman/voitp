-- Find all users with the "Ruby" (id = 3) specialty

SELECT e.phone_number
FROM experts e
INNER JOIN experts_specialties es
ON e.id = es.expert_id
AND es.specialty_id = 3

SELECT DISTINCT(e.phone_number)
FROM experts e
INNER JOIN experts_specialties es
ON e.id = es.expert_id
JOIN specialties s
ON es.specialty_id = s.id
AND s.context = 'au319_code'
AND s.extension = '2'

-- Find all users who are available on Tuesday

SELECT DISTINCT(e.phone_number)
FROM experts e
INNER JOIN availability a
ON e.id = a.expert_id
AND a.day IN (2)

-- ...and it's 6pm

SELECT DISTINCT(e.phone_number)
FROM experts e
INNER JOIN availability a
ON e.id = a.expert_id
AND a.day IN (2)
AND (('18:00:00' BETWEEN a.from AND a.through) OR a.allday = TRUE)

-- Find all specialties sorted by topic and specialty name
-- Useful for dynamically building a configuration screen

SELECT s.id specialty_id, s.name specialty_name, t.id topic_id, t.name topic_name
FROM specialties s
LEFT JOIN topics t
ON s.topic_id = t.id
ORDER BY topic_name, specialty_name

-- Find all specialties and identify those for a specific expert

SELECT s.id, s.name, t.name, IF(es.expert_id IS NOT NULL, TRUE, FALSE) AS checked
FROM specialties s
LEFT JOIN topics t
ON s.topic_id = t.id
LEFT JOIN experts_specialties es
ON s.id = es.specialty_id
AND es.expert_id = 1
ORDER BY t.name, s.name

-- Find expert ID and phone number matching the criteria:
-- Has specialty matching: context = au319_code, extension = 2
-- Available now
-- Called least recently

SELECT DISTINCT(e.id), e.phone_number
FROM experts e
INNER JOIN experts_specialties es
	ON e.id = es.expert_id
INNER JOIN specialties s
	ON es.specialty_id = s.id
	AND s.context = 'au319_code'
	AND s.extension = '2'
INNER JOIN availability a
	ON e.id = a.expert_id
	AND a.day IN (DAYOFWEEK(CURRENT_DATE()))
	AND ((CURTIME() BETWEEN a.from AND a.through) OR a.allday = TRUE)
LEFT JOIN calls c
	ON e.id = c.expert_id
ORDER BY c.created_on ASC
LIMIT 1
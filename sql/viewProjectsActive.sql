CREATE VIEW viewProjectsActive AS
SELECT
	p.idProject AS idProject,
	p.idLocalProject AS idLocalProject,
	p.idProjectType AS idProjectType,
	rpt.name AS projectTypeName,
	p.idProjectSubtype AS idProjectSubtype,
	rps.name AS projectSubtypeName,
	p.created AS created,
	CONCAT(UCASE(LEFT(p.name, 1)), SUBSTRING(p.name, 2)) AS name,
	CONCAT(UCASE(LEFT(p.subject, 1)), SUBSTRING(p.subject, 2))  AS subject,
	p.editor AS editor,
	u.name AS editorName,
	p.author AS author,
	p.idFinSources AS idFinSources,
	p.idPhase AS idPhase,
	rp.name AS phaseName,
	p.ginisOrAthena AS ginisOrAthena,
	p.noteGinisOrAthena AS noteGinisOrAthena,
	p.inConcept AS inConcept,
	p.dateEvidence AS dateEvidence
FROM projects p
JOIN rangeProjectTypes rpt ON p.idProjectType = rpt.idProjectType
LEFT JOIN rangeProjectSubtypes rps ON p.idProjectSubtype = rps.idProjectSubtype
JOIN users u ON u.username = p.editor
JOIN rangePhases rp ON rp.idPhase = p.idPhase
WHERE
p.deletedDate IS NULL and
p.deleteAuthor IS NULL
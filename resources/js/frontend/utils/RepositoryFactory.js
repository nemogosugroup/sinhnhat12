import UserRepository from '@frontend/api/user/index';
import RoleRepository from '@frontend/api/role';
import ProjectRepository from '@frontend/api/project';
import langRepository from '@frontend/api/lang/index';
import mapRepository from '@frontend/api/map/index';
const repositories = {
	user: UserRepository,
	role: RoleRepository,
	project: ProjectRepository,
	lang: langRepository,
	map: mapRepository,
}
const RepositoryFactory = {
	get: name => repositories[name]
}
export default RepositoryFactory